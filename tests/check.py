"""HTTP checks for the cumulative ResearchMate workspace."""
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


def check_week(week, php, php_args=()):
    with socket.socket() as sock:
        sock.bind(("127.0.0.1", 0))
        port = sock.getsockname()[1]
    router = ROOT / "vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php"
    env = dict(os.environ, APP_ENV="local", APP_DEBUG="false")
    with tempfile.TemporaryFile() as log:
        server = subprocess.Popen(
            [php, *php_args, "-S", f"127.0.0.1:{port}", str(router)],
            cwd=ROOT / "public", stdout=log, stderr=log, env=env,
        )
        base = f"http://127.0.0.1:{port}"
        client = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(http.cookiejar.CookieJar()))

        def request(path, data=None, status=200, contains=None, referer="/"):
            payload = urllib.parse.urlencode(data).encode() if data is not None else None
            req = urllib.request.Request(base + path, data=payload, headers={"Referer": base + referer})
            try:
                response = client.open(req, timeout=30)
            except urllib.error.HTTPError as error:
                response = error
            body = response.read().decode()
            assert response.status == status, (path, response.status, body[:400])
            if contains:
                assert contains in body, (path, contains)
            return body

        def token(body):
            match = re.search(r'name="_token" value="([^"]+)"', body)
            assert match, "CSRF token missing"
            return match[1]

        def field(body, name):
            match = re.search(r'name="' + re.escape(name) + r'" value="([^"]+)"', body)
            assert match, f"{name} missing"
            return match[1]

        test_account_email = None
        try:
            for _ in range(100):
                try:
                    with socket.create_connection(("127.0.0.1", port), timeout=.1):
                        break
                except OSError:
                    if server.poll() is not None:
                        raise RuntimeError("PHP server failed to start")
                    time.sleep(.05)

            if week in (1, 6, 10):
                home = request("/", contains="ResearchMate AI")
                assert "Marco Marcello Hugo" in home and "5025221102" in home
                request("/about", contains="Teknik Informatika ITS")
                request("/project-idea", contains="ResearchMate AI")
                request("/kalkulator", contains='name="angka1"')
                for op, expected in (("tambah", 15), ("kurang", 5), ("kali", 50), ("bagi", 2)):
                    request(f"/hitung/10/5/{op}", contains=f"Hasil: {expected}")
                request("/hitung/10/0/bagi", status=422, contains="Pembagian dengan nol")

            if week in (2, 6, 10):
                request("/mahasiswa/5025221102", contains="5025221102")
                request("/mahasiswa/123", status=404)
                request("/agent", contains="General Assistant Agent")
                request("/agent/ResearchMate%20AI", contains="ResearchMate AI")
                escaped = request("/agent/%3Cscript%3E", contains="&lt;script&gt;")
                assert "<script>" not in escaped
                request("/hitung-ipk/3.5/4", contains="3.75")
                request("/hitung-ipk/5/4", status=422)
                request("/dashboard", contains="Masuk ke ruang kerja")
                request("/missing", status=404)
                routes = json.loads(subprocess.check_output([php, *php_args, "artisan", "route:list", "--json"], cwd=ROOT))
                assert all(route["name"] for route in routes if not route["uri"].startswith("storage/"))

            if week in (3, 6, 10):
                form = request("/feedback", contains="Masukan pengguna")
                a, b = map(int, re.search(r"Berapakah (\d+) \+ (\d+)\?", form).groups())
                data = {"_token": token(form), "nama": "Marco Marcello Hugo", "email": "marco@student.its.ac.id",
                        "kategori": "Akademik", "pesan": "Literatur perlu rujukan yang jelas.", "captcha": a + b,
                        "konteks": "literatur"}
                request("/feedback", {**data, "_token": "bad"}, status=419)
                invalid = request("/feedback", {**data, "nama": "M", "email": "x@example.com",
                                                "kategori": "invalid", "pesan": "pendek", "captcha": 999},
                                  contains="Nama pengirim minimal 3 karakter.", referer="/feedback")
                assert 'value="x@example.com"' in invalid and 'value="M"' in invalid
                assert "@student.its.ac.id" in invalid and "Isi pesan minimal 15 karakter." in invalid
                request("/feedback", {**data, "konteks": "permainan"}, contains="Pilih konteks riset", referer="/feedback")
                body = request("/feedback", data, contains="Masukan berhasil divalidasi", referer="/feedback")
                assert "Literatur perlu rujukan" in body

            if week in (4, 6, 10):
                request("/profil-mahasiswa", contains="5025221102")
                request("/beranda?user=Andi", contains="Selamat datang, Andi!")
                idea = request("/ide-agent?mode=dark", contains='class="dark"')
                request("/ide-agent?mode=light", contains="Rencana penelitian")
                idea_data = {"_token": token(idea), "nama": "Marco", "judul": "Riset adaptif",
                             "deskripsi": "Meninjau metode pembelajaran adaptif di perguruan tinggi.",
                             "mode": "dark"}
                request("/ide-agent", {**idea_data, "_token": "bad"}, status=419)
                request("/ide-agent", {**idea_data, "judul": "x"}, contains="minimal 5 karakter", referer="/ide-agent?mode=dark")
                request("/ide-agent", idea_data, contains="berhasil divalidasi", referer="/ide-agent?mode=dark")
                request("/rencana-riset", {**idea_data, "_token": "bad"}, status=419)
                plan = {"_token": token(idea), "mode": "dark",
                        "pertanyaan_riset": "Bagaimana pembelajaran adaptif memengaruhi keterlibatan mahasiswa?",
                        "mode_riset": "dokumen_lokal", "jumlah_artikel": 4, "jumlah_pdf": 2}
                result = request("/rencana-riset", plan, contains="4 artikel dan 2 PDF")
                assert 'class="dark"' in result
                request("/rencana-riset", {**plan, "jumlah_artikel": -1},
                        contains="harus antara 0 dan 1000", referer="/ide-agent?mode=dark")

            if week in (6, 10):
                request("/dashboard", contains="Masuk ke ruang kerja")
                register = request("/register?next=research", contains="Buat akun baru")
                email = f"researchcheck{time.time_ns()}@example.com"
                test_account_email = email
                account = {"_token": token(register), "name": "Peneliti Uji", "email": email,
                           "password": "password123", "password_confirmation": "password123"}
                request("/register", {**account, "email": "invalid"}, contains="email", referer="/register?next=research")
                idea = request("/register", account, contains="Simpan rencana ke Proyek Saya", referer="/register?next=research")
                assert 'class="dark"' in idea
                old_plan_token = field(idea, "plan_token")
                dashboard = request("/dashboard", contains="Belum ada proyek")
                assert "Pemetaan literatur pembelajaran adaptif" not in dashboard
                invalid = request("/ide-agent", {"_token": token(idea), "judul": "x", "deskripsi": "pendek",
                                                       "plan_token": old_plan_token},
                                  contains="minimal 5 karakter", referer="/ide-agent")
                assert "Belum ada proyek" in request("/dashboard")
                revised_plan = {**plan, "_token": token(invalid), "jumlah_artikel": 5,
                                "pertanyaan_riset": "Bagaimana metode adaptif meningkatkan partisipasi mahasiswa?"}
                revised = request("/rencana-riset", revised_plan, contains="5 artikel dan 2 PDF", referer="/ide-agent?mode=dark")
                new_plan_token = field(revised, "plan_token")
                assert new_plan_token != old_plan_token
                project_data = {"judul": "Peta pembelajaran adaptif pribadi",
                                "deskripsi": "Meninjau dampak pembelajaran adaptif pada mahasiswa."}
                request("/ide-agent", {"_token": token(revised), "plan_token": old_plan_token, **project_data},
                        contains="Rencana berubah", referer="/ide-agent?mode=dark")
                assert "Belum ada proyek" in request("/dashboard")
                saved = request("/ide-agent", {"_token": token(revised), "judul": "Peta pembelajaran adaptif pribadi",
                                                 "deskripsi": "Meninjau dampak pembelajaran adaptif pada mahasiswa.",
                                                 "plan_token": new_plan_token},
                                contains="berhasil disimpan", referer="/ide-agent")
                assert "5 artikel" in saved and "2 PDF" in saved
                assert revised_plan["pertanyaan_riset"] in saved
                assert "Rencana belum disimpan" not in saved
                project_path = re.search(r"/dashboard/proyek/\d+", saved).group()
                detail = request(project_path, contains=revised_plan["pertanyaan_riset"])
                assert "5 artikel" in detail and "2 PDF" in detail and "Dokumen lokal" in detail
                request("/logout", {"_token": token(saved)}, contains="ResearchMate AI")
                request(project_path, contains="Masuk ke ruang kerja")
                guest_form = request("/ide-agent", contains="Rencana penelitian")
                request("/rencana-riset", {**plan, "_token": token(guest_form)}, contains="4 artikel dan 2 PDF")
                login = request("/login?next=research", contains="Masuk ke ruang kerja")
                resumed = request("/login", {"_token": token(login), "email": "dosenpbkk@its.ac.id",
                                             "password": "demo12345"}, contains="Simpan rencana ke Proyek Saya")
                assert "4 artikel" in resumed and 'class="dark"' in resumed
                demo = request("/dashboard", contains="Pemetaan literatur pembelajaran adaptif")
                assert "Peta pembelajaran adaptif pribadi" not in demo
                request(project_path, status=404)
                reset = request("/rencana-riset/baru", {"_token": token(demo)}, contains="Rencana penelitian", referer="/dashboard")
                assert "Simpan rencana ke Proyek Saya" not in reset
                assert "Rencana belum disimpan" not in request("/dashboard")
            if week == 10:
                request("/admin/dashboard", status=403)
                request("/logout", {"_token": token(demo)}, contains="ResearchMate AI")
                request("/admin/dashboard", contains="Masuk ke ruang kerja")
                login = request("/login", contains="Masuk sebagai Admin")
                admin = request("/login/demo/admin", {"_token": token(login)}, contains="Dashboard Riset", referer="/login")
                for label in ("Pengguna", "Proyek riset", "Masukan", "Hapus Data"):
                    assert label in admin
                filtered = request("/admin/dashboard?q=a", contains="Daftar proyek riset")
                assert "q=a" in re.search(r'href="([^"]*page=2[^"]*)"', filtered).group(1)
                project_id = project_path.rsplit("/", 1)[1]
                target = f"/admin/projects/{project_id}"
                request("/logout", {"_token": token(admin)}, contains="ResearchMate AI")
                login = request("/login", contains="Masuk sebagai Staf")
                staff = request("/login/demo/staf", {"_token": token(login)}, contains="Dashboard Riset", referer="/login")
                assert "Hapus Data" not in staff
                request(target, {"_token": token(staff), "_method": "DELETE"}, status=403, referer="/admin/dashboard")
                request("/admin/dashboard?q=Peta%20pembelajaran%20adaptif%20pribadi",
                        contains="Peta pembelajaran adaptif pribadi")
                request("/logout", {"_token": token(staff)}, contains="ResearchMate AI")
                login = request("/login", contains="Masuk sebagai Admin")
                admin = request("/login/demo/admin", {"_token": token(login)}, contains="Dashboard Riset", referer="/login")
                request(target, {"_token": token(admin), "_method": "DELETE"},
                        contains="Proyek berhasil dihapus", referer="/admin/dashboard")
                request("/admin/dashboard?q=Peta%20pembelajaran%20adaptif%20pribadi",
                        contains="Tidak ada proyek yang cocok dengan pencarian.")
            print(f"PASS W{week}: routes, validation, sessions, and feature checks")
        except Exception:
            log.seek(0)
            print(log.read().decode(errors="replace")[-3000:])
            raise
        finally:
            server.terminate()
            server.wait(timeout=10)
            if test_account_email:
                cleanup = ("require 'vendor/autoload.php'; $app = require 'bootstrap/app.php'; "
                           "$app->make(\\Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap(); "
                           "\\App\\Models\\User::where('email', getenv('CHECK_EMAIL'))->delete();")
                subprocess.check_call([php, *php_args, "-r", cleanup], cwd=ROOT,
                                      env=dict(env, CHECK_EMAIL=test_account_email))


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("--php", default="php")
    parser.add_argument("--week", type=int, choices=[1, 2, 3, 4, 6, 10], default=10)
    parser.add_argument("--php-arg", action="append", default=[])
    args = parser.parse_args()
    check_week(args.week, args.php, args.php_arg)
