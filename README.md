# W4 — Profil Akademik Multi-View

Marco Marcello Hugo · 5025221102

Sumber: `pertemuan_4_lengkap-ok.pptx`, slide 39–43 (nomor urut file).

Tema proyek: **Narafin AI Coach — Saran Analitika Pemain**. Tahap W4: demo saran dari metrik simulasi dan bukti angka. Dasarnya adalah bagian Saran pada Analitika Pemain Cashflowpoly di [Narafin](https://narafin.org). Detail sumber, batas implementasi, dan perkembangan W1–W4 ada di [rencana AI](docs/narafin-ai.md).

## Menjalankan

Dari root proyek, aktifkan runtime lokal dengan `. .\dev-env.ps1`, lalu:

```powershell
npm ci
npm run build
php artisan serve --host=127.0.0.1 --port=8004
```

Buka http://127.0.0.1:8004. Dependensi dan `.env` sudah disiapkan di komputer ini. Untuk instalasi baru, jalankan `composer install`, salin `.env.example` ke `.env`, kemudian `php artisan key:generate`.

## Pemetaan tugas dan challenge

| Ketentuan | Implementasi |
| --- | --- |
| Master layout | layouts/app.blade.php: title dinamis, navbar, konten, footer ITS |
| Tiga halaman | /, /profil-mahasiswa, /ide-agent melalui PageController |
| Pewarisan | Semua halaman anak memakai @extends dan @section |
| Komponen | x-info-card dan x-status-banner, props, slot, attributes->class() |
| Vite | Tailwind melalui NPM, @vite, aset lokal tanpa CDN |
| Form ide | POST + CSRF, validasi, old input, status dan ringkasan ide |
| Challenge mode | /ide-agent?mode=dark mengatur class Tailwind dari variabel Blade |
| Challenge sapaan | /beranda?user=Andi menampilkan sapaan dinamis aman |
| Demo saran Narafin | POST /saran-pemain, validasi metrik, bukti angka, prioritas pinjaman pada Mahir, dan data kosong |

## Urutan demo

1. Jalankan `npm ci` dan `npm run build` jika aset belum tersedia.
2. Buka ketiga halaman lewat navbar.
3. Bandingkan `/ide-agent` dengan `/ide-agent?mode=dark`.
4. Buka `/beranda?user=Andi`.
5. Kirim ide yang valid, lalu tunjukkan master layout dan dua komponen Blade.
6. Di `/ide-agent#demo-saran`, ubah metrik simulasi dan susun saran. Bandingkan Pemula/Mahir, sisa pinjaman 0/kosong, serta bahan terpakai 40%/60%.

## Pengujian dan screenshot

Jalankan `python tests/check.py` setelah mengaktifkan runtime, atau `python tests/check.py --php C:\path\to\php.exe`. Tes menyesuaikan minggu dengan branch dan memeriksa fitur Laravel serta konteks saran Narafin.

Screenshot aplikasi saat ini: [desktop](docs/desktop.png), [mobile](docs/mobile.png), dan [mode gelap](docs/dark-idea.png).

Data form hanya ditampilkan melalui flash session pada konfirmasi setelah redirect, tanpa database atau pengiriman eksternal. Refresh konfirmasi berikutnya dapat menghapus data flash.

## Berkas utama

- `routes/web.php`: deklarasi rute.
- `app/Http/Controllers/PageController.php`: penanganan request.
- `resources/views/`: Blade layout dan halaman.
- `config/profile.php`: identitas dan usulan tema.

`.env` dan `vendor/` dikecualikan oleh `.gitignore`. Source code tersedia di [branch w4 GitHub](https://github.com/Marcellohugo/PBKK/tree/w4). Tautan branch dan screenshot dikumpulkan ke LMS oleh pemilik tugas.
