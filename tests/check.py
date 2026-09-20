"""HTTP integration checks with real sessions/CSRF. Python stdlib, no test framework.

Run: python tests/check.py --php /path/to/php
"""
import argparse
import http.cookiejar
import json
import os
from pathlib import Path
import re
import socket
import subprocess
import tempfile
import time
import urllib.error
import urllib.parse
import urllib.request

ROOT = Path(__file__).resolve().parents[1]


def check_week(week, php):
    with socket.socket() as sock:
        sock.bind(('127.0.0.1', 0))
        port = sock.getsockname()[1]
    app = ROOT
    env = dict(os.environ, APP_ENV='local', APP_DEBUG='false')
    router = app / 'vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php'
    with tempfile.TemporaryFile() as log:
        server = subprocess.Popen(
            [php, '-S', f'127.0.0.1:{port}', str(router)],
            cwd=app / 'public', stdout=log, stderr=log, env=env,
        )
        base = f'http://127.0.0.1:{port}'
        client = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(http.cookiejar.CookieJar()))

        def request(path, data=None, status=200, contains=None, referer=None):
            headers = {'Referer': base + (referer or ('/feedback' if path == '/feedback' else '/'))}
            payload = urllib.parse.urlencode(data).encode() if data is not None else None
            req = urllib.request.Request(base + path, data=payload, headers=headers)
            try:
                response = client.open(req, timeout=10)
            except urllib.error.HTTPError as error:
                response = error
            body = response.read().decode()
            assert response.status == status, (week, path, response.status, body[:300])
            if contains:
                assert contains in body, (week, path, contains)
            return body

        def token(body):
            return re.search(r'name="_token" value="([^"]+)"', body)[1]

        try:
            for _ in range(100):
                try:
                    with socket.create_connection(('127.0.0.1', port), timeout=.1):
                        break
                except OSError:
                    if server.poll() is not None:
                        raise RuntimeError('PHP server failed to start')
                    time.sleep(.05)
            if week == 1:
                request('/', contains='Marco Marcello Hugo')
                request('/about', contains='Teknik Informatika ITS')
                request('/project-idea', contains='Narafin AI Coach')
                request('/kalkulator', contains='name="angka1"')
                for operation, result in [('tambah',15),('kurang',5),('kali',50),('bagi',2)]:
                    request(f'/hitung/10/5/{operation}', contains=f'adalah {result}')
                request('/hitung/-1.5/2/tambah', contains='adalah 0.5')
                request('/hitung/10/0/bagi', status=422, contains='Pembagian dengan nol')
                request('/hitung/nope/5/tambah', status=422)
                request('/hitung/1/2/invalid', status=422)
                request('/hitung/1e999/2/kali', status=422)
                request('/kalkulator?angka1=6&angka2=3&operasi=bagi', contains='adalah 2')
            elif week == 2:
                request('/', contains='Marco Marcello Hugo')
                request('/mahasiswa/5025221102', contains='5025221102')
                for path in ['/mahasiswa/123', '/mahasiswa/abcdefghij', '/mahasiswa/9999999999', '/missing']:
                    request(path, status=404, contains='tidak ditemukan')
                request('/agent', contains='General Assistant Agent')
                request('/agent/Network%20Agent', contains='Network Agent')
                body = request('/agent/%3Cscript%3E', contains='&lt;script&gt;')
                assert '<script>' not in body
                request('/dashboard')
                request('/dashboard/mahasiswa/5025221102')
                request('/dashboard/agent')
                body = request('/agent?mode=pemula', contains='Kas menurun')
                assert 'Masih ada pinjaman' not in body
                request('/agent?mode=mahir', contains='Masih ada pinjaman')
                request('/agent?mode=invalid', contains='Pilihan mode tidak valid', referer='/agent')
                request('/hitung-ipk/3.5/4', contains='3.75')
                request('/hitung-ipk/0/0', contains='0.00')
                for a in ['5', '-1', 'abc', '1e999']:
                    request(f'/hitung-ipk/{a}/3', status=422)
                request('/ipk?ip1=3.5&ip2=4', contains='3.75')
                routes = json.loads(subprocess.check_output([php, 'artisan', 'route:list', '--json'], cwd=app))
                assert all(route['name'] for route in routes if not route['uri'].startswith('storage/'))
            elif week == 3:
                request('/', contains='Marco Marcello Hugo')
                request('/about', contains='Teknik Informatika ITS')
                request('/hitung/10/5/bagi', contains='adalah 2')
                request('/mahasiswa/5025221102', contains='5025221102')
                request('/agent?mode=mahir', contains='Masih ada pinjaman')
                request('/hitung-ipk/3.5/4', contains='3.75')
                form = request('/feedback', contains='Secure Feedback Hub')
                csrf = token(form)
                a,b = map(int, re.search(r'Berapakah (\d+) \+ (\d+)\?', form).groups())
                data = {'_token':csrf, 'nama':'Marco Marcello Hugo', 'email':'marco@student.its.ac.id',
                        'kategori':'Akademik', 'pesan':'Saran perlu menjelaskan kaitan kas dengan stok bahan.', 'captcha':a+b,
                        'mode_permainan':'pemula', 'indikator':'kas'}
                request('/feedback', {**data,'_token':'bad'}, status=419)
                request('/feedback', {k:v for k,v in data.items() if k != '_token'}, status=419)
                invalid = request('/feedback', {**data,'nama':'M','email':'marco@example.com','kategori':'invalid','pesan':'pendek','captcha':999})
                for message in ['minimal 3 karakter', '@student.its.ac.id', 'Pilih salah satu kategori', 'minimal 15 karakter', 'Jawaban matematika salah']:
                    assert message in invalid, message
                assert 'value="M"' in invalid and '>pendek</textarea>' in invalid
                invalid = request('/feedback', {**data, 'captcha':999})
                assert re.search(r'value="Akademik"\s+selected', invalid)
                for email in ['x@student.its.ac.id.evil.com', 'not-an-email@student.its.ac.id@evil.com']:
                    request('/feedback', {**data,'email':email}, contains='email')
                request('/feedback', {**data,'indikator':'pinjaman'}, contains='Pinjaman hanya berlaku pada Mahir')
                request('/feedback', {**data,'mode_permainan':'invalid'}, contains='Pilih mode Pemula atau Mahir')
                request('/feedback', {**data,'indikator':''}, contains='Lengkapi mode dan indikator')
                request('/feedback', {**data,'mode_permainan':''}, contains='Lengkapi mode dan indikator')
                general = {k:v for k,v in data.items() if k not in ('mode_permainan', 'indikator')}
                request('/feedback', general, contains='berhasil divalidasi')
                form = request('/feedback')
                data['_token'] = token(form)
                a,b = map(int, re.search(r'Berapakah (\d+) \+ (\d+)\?', form).groups())
                data['captcha'] = a+b
                body = request('/feedback', {**data,'pesan':'<script>alert("test")</script>'}, contains='berhasil divalidasi')
                assert '&lt;script&gt;' in body and '<script>' not in body
                request('/feedback', data, contains='sesi telah kedaluwarsa')
                request('/feedback/sukses', contains='Secure Feedback Hub')
            else:
                request('/', contains='Marco Marcello Hugo')
                request('/profil-mahasiswa', contains='5025221102')
                request('/beranda?user=Andi', contains='Selamat datang, Andi!')
                body = request('/beranda?user=%3Cscript%3E', contains='&lt;script&gt;')
                assert '<script>' not in body
                body = request('/ide-agent?mode=dark', contains='class="dark"')
                assert 'bg-slate-950 text-slate-100' in body
                assert 'cdn.jsdelivr.net' not in body and 'cdn.tailwindcss.com' not in body
                css = re.search(r'href="([^"]+\.css)"', body)[1]
                request(urllib.parse.urlsplit(css).path, contains='dark')
                request('/ide-agent?mode=light', contains='bg-slate-50 text-slate-900')
                request('/ide-agent?permainan=&mode=', contains='Mode Mahir')
                data = {'_token':token(body), 'nama':'Marco', 'judul':'Narafin AI Coach', 'deskripsi':'Saran permainan berdasarkan kas dan pemakaian bahan.', 'mode':'dark'}
                request('/ide-agent', {**data,'_token':'bad'}, status=419)
                request('/ide-agent', {**data,'judul':'x'}, contains='minimal 5 karakter', referer='/ide-agent?mode=dark')
                body = request('/ide-agent', data, contains='berhasil divalidasi')
                assert 'class="dark"' in body and 'Saran permainan berdasarkan kas dan pemakaian bahan.' in body
                csrf = token(body)
                metrics = {'_token':csrf, 'mode':'dark', 'mode_permainan':'mahir',
                           'koin_awal':20, 'koin_akhir':12, 'bahan_terkumpul':10, 'bahan_terpakai':4, 'sisa_pinjaman':6}
                request('/saran-pemain', {**metrics,'_token':'bad'}, status=419)
                body = request('/saran-pemain', metrics)
                assert 'class="dark"' in body and 'perubahan -40%' in body and '(40%)' in body
                assert body.index('Prioritas · Pinjaman belum lunas') < body.index('Koin awal 20, koin akhir 12')
                request('/saran-pemain', {**metrics,'bahan_terpakai':11}, contains='tidak boleh melebihi', referer='/ide-agent')
                request('/saran-pemain', {**metrics,'koin_awal':0}, contains='harus antara', referer='/ide-agent')
                request('/saran-pemain', {**metrics,'mode_permainan':'pemula'}, contains='Pinjaman hanya berlaku', referer='/ide-agent')
                request('/saran-pemain', {**metrics,'mode_permainan':'invalid'}, contains='tidak valid', referer='/ide-agent')
                for changes in [{'bahan_terkumpul':'','bahan_terpakai':''}, {'bahan_terkumpul':0,'bahan_terpakai':0}]:
                    request('/saran-pemain', {**metrics,**changes,'sisa_pinjaman':''}, contains='Nilai belum tersedia tidak dianggap 0%')
                request('/saran-pemain', {**metrics,'bahan_terkumpul':10,'bahan_terpakai':''}, contains='Isi kedua jumlah bahan', referer='/ide-agent')
                pemula = {k:v for k,v in metrics.items() if k != 'sisa_pinjaman'}
                body = request('/saran-pemain', {**pemula,'mode_permainan':'pemula','bahan_terpakai':6,'koin_akhir':24})
                assert 'perubahan 20%' in body and 'Periksa bahan tersisa dan keuntungan pesanan' in body
                assert 'Prioritas · Pinjaman belum lunas' not in body and 'Status pinjaman' not in body
                request('/saran-pemain', {**metrics,'bahan_terkumpul':100000,'bahan_terpakai':59999}, contains='Pemakaian bahan masih rendah')
                request('/saran-pemain', {**metrics,'koin_awal':1000000,'koin_akhir':999999}, contains='Kas menurun')
                request('/saran-pemain', {**metrics,'sisa_pinjaman':0}, contains='Tidak ada sisa pinjaman pada input ini')
            print(f'PASS W{week}: routes, validation and applicable session/security checks')
        except Exception:
            log.seek(0)
            print(log.read().decode(errors='replace')[-3000:])
            raise
        finally:
            server.terminate()
            server.wait(timeout=10)


if __name__ == '__main__':
    parser = argparse.ArgumentParser()
    parser.add_argument('--php', default='php')
    parser.add_argument('--week', type=int, choices=[1,2,3,4],
                        default=int(re.search(r'PBKK W(\d)', (ROOT / '.env.example').read_text())[1]))
    args = parser.parse_args()
    check_week(args.week, args.php)
