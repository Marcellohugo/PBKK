# W1 — ITS Academic Profile

Marco Marcello Hugo · 5025221102

Sumber: `pertemuan_1_lengkap-ok.pptx`, slide 39–43 (nomor urut file).

## Menjalankan

Dari root proyek, aktifkan runtime lokal dengan `. .\dev-env.ps1`, lalu:

```powershell
php artisan serve --host=127.0.0.1 --port=8001
```

Buka http://127.0.0.1:8001. Dependensi dan `.env` sudah disiapkan di komputer ini. Untuk instalasi baru, jalankan `composer install`, salin `.env.example` ke `.env`, kemudian `php artisan key:generate`.

## Pemetaan tugas dan challenge

| Ketentuan | Implementasi |
| --- | --- |
| Home / | PageController@index, home.blade.php, nama dan NRP |
| /about | PageController@about, about.blade.php, profil departemen |
| /project-idea | PageController@project, project.blade.php, rancangan Agentic AI |
| /hitung/{angka1}/{angka2}/{operasi} | Empat operasi, validasi angka dan pembagian nol |
| Tampilan | Bootstrap 5 CDN, navbar empat halaman, responsif |

## Urutan demo

1. Buka `/`, `/about`, dan `/project-idea` dari navbar.
2. Buka `/hitung/10/5/kali`: hasil 50.
3. Buka `/hitung/10/0/bagi`: pesan kesalahan, HTTP 422.
4. Tunjukkan `routes/web.php`, `PageController`, lalu view. Semua rute halaman menggunakan controller tanpa closure.

## Pengujian dan screenshot

Screenshot: [desktop](docs/desktop.png) dan [mobile](docs/mobile.png).

[Presentasi lima slide](docs/presentasi-w1.pptx) berisi hasil instalasi, alur request, tampilan, dan skenario demo individu. Tambahkan hasil anggota kelompok sesuai data aktual sebelum presentasi kelompok.

## Berkas utama

- `routes/web.php`: deklarasi rute.
- `app/Http/Controllers/PageController.php`: penanganan request.
- `resources/views/`: Blade layout dan halaman.
- `config/profile.php`: identitas dan usulan tema.

`.env` dan `vendor/` dikecualikan oleh `.gitignore`. Pengunggahan GitHub dan pengumpulan LMS dilakukan terpisah oleh pemilik tugas.
