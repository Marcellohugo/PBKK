# W2 — Laravel Local Sandbox

Marco Marcello Hugo · 5025221102

Sumber: `pertemuan_2_lengkap-ok.pptx`, slide 38–42 (nomor urut file).

Tema proyek: **Narafin AI Coach — Saran Analitika Pemain**. Tahap W2: skenario saran berdasarkan mode Pemula/Mahir. Dasarnya adalah bagian Saran pada Analitika Pemain Cashflowpoly di [Narafin](https://narafin.org). Detail sumber, batas implementasi, dan perkembangan W1–W4 ada di [rencana AI](docs/narafin-ai.md).

## Menjalankan

Dari root proyek, aktifkan runtime lokal dengan `. .\dev-env.ps1`, lalu:

```powershell
php artisan serve --host=127.0.0.1 --port=8002
```

Buka http://127.0.0.1:8002. Dependensi dan `.env` sudah disiapkan di komputer ini. Untuk instalasi baru, jalankan `composer install`, salin `.env.example` ke `.env`, kemudian `php artisan key:generate`.

## Pemetaan tugas dan challenge

| Ketentuan | Implementasi |
| --- | --- |
| / | Sambutan dan profil dengan details HTML interaktif |
| /mahasiswa/{nrp} | Profil sesuai NRP terdaftar, regex tepat 10 digit |
| /agent/{tema?} | Tema opsional, fallback General Assistant Agent |
| Named routes | Seluruh rute aplikasi bernama, navigasi memakai route() |
| /dashboard | Grup prefix untuk home, mahasiswa, dan agent |
| /hitung-ipk/{ip1}/{ip2} | Jumlah dan rata-rata dua IP, validasi rentang 0–4 |
| Fallback | Halaman kustom dengan status HTTP 404 |

## Urutan demo

1. Buka `/mahasiswa/5025221102`, lalu `/mahasiswa/123` untuk penolakan regex.
2. Bandingkan `/agent` dengan `/agent/Network%20Agent`.
3. Buka `/dashboard/mahasiswa/5025221102`.
4. Buka `/hitung-ipk/3.5/4`: jumlah 7.5 dan rata-rata 3.75.
5. Buka URL tidak dikenal dan jalankan `php artisan route:list --except-vendor`.
6. Bandingkan `/agent?mode=pemula` dengan `/agent?mode=mahir`; contoh pinjaman hanya muncul pada Mahir.

## Pengujian dan screenshot

Jalankan `python tests/check.py` setelah mengaktifkan runtime, atau `python tests/check.py --php C:\path\to\php.exe`. Tes menyesuaikan minggu dengan branch dan memeriksa fitur Laravel serta konteks saran Narafin.

Screenshot aplikasi saat ini: [desktop](docs/desktop.png), [mobile](docs/mobile.png), dan [profil](docs/profile.png).

IPK menggunakan rata-rata aritmetika sesuai soal (asumsi SKS sama), bukan perhitungan transkrip berbobot SKS. Riwayat studi pada profil merangkum pekerjaan PBKK pertemuan 1–2 yang tersedia; transkrip resmi belum diberikan.

## Berkas utama

- `routes/web.php`: deklarasi rute.
- `app/Http/Controllers/PageController.php`: penanganan request.
- `resources/views/`: Blade layout dan halaman.
- `config/profile.php`: identitas dan usulan tema.

`.env` dan `vendor/` dikecualikan oleh `.gitignore`. Source code tersedia di [branch w2 GitHub](https://github.com/Marcellohugo/PBKK/tree/w2). Tautan branch dan screenshot dikumpulkan ke LMS oleh pemilik tugas.
