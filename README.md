# PBKK — Portofolio Akademik dan Proyek Agentic AI

Marco Marcello Hugo · 5025221102. Branch `w6` mengerjakan tugas pada `pertemuan_6_lengkap-ok.pptx` dan mempertahankan fitur pertemuan 1–4. Tema utama: **Narafin AI Coach — Saran Analitika Pemain**.

## Menjalankan dengan MySQL

Butuh PHP 8.3+, ekstensi `pdo_mysql`, Composer, Node.js, dan MySQL 8. Buat database kosong bernama `pbkk_w6`, lalu dari root proyek:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
# Isi DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD di .env
php artisan migrate --seed
npm ci
npm run build
php artisan serve --host=127.0.0.1 --port=8006
```

Jika memakai runtime lokal pada repo ini, jalankan `. .\dev-env.ps1` sebelum perintah PHP. Akses `http://127.0.0.1:8006`. Akun demo lokal: `dosenpbkk@its.ac.id` / `demo12345`. Ganti kata sandi ini jika menggunakan data di luar lingkungan pengembangan. Pendaftaran mahasiswa mensyaratkan email `@student.its.ac.id`.

File `.env`, `vendor/`, dan `node_modules/` diabaikan Git. `api_key_secure` menggunakan cast terenkripsi Laravel dan tidak pernah ditampilkan di halaman. Nilai kolom ini boleh kosong sampai integrasi API diperlukan.

## Fitur database

- Tabel `users` memuat nama, email unik, dan kata sandi yang di-hash; tabel `projects` memuat `judul`, `deskripsi` opsional, `tema_agent` default `Ollama`, `api_key_secure`, dan `user_id` yang merujuk ke users dengan cascade delete.
- Relasi Eloquent `User::projects()` dan `Project::user()`. `Project::$fillable` hanya mengizinkan kolom konten, sehingga pemilik dan API key tidak dapat diubah lewat mass assignment biasa.
- `ProjectFactory` membuat data Agentic AI; `DatabaseSeeder` membuat 15 mahasiswa × 2 proyek serta satu akun demo dengan 2 proyek portofolio.
- Login dan pendaftaran menggunakan alur autentikasi Laravel Breeze. `/dashboard` hanya bisa diakses pengguna login; query mengambil proyek milik pengguna tersebut dan mengurutkannya dari yang terbaru.

## Fitur dari pertemuan sebelumnya

Beranda, profil, ide Agentic AI dan demo saran, kalkulator, feedback, rute parameter, komponen Blade, validasi, dan layout ITS tetap tersedia. Dokumentasi rancangan AI ada di [docs/narafin-ai.md](docs/narafin-ai.md).

## Verifikasi

Jalankan `python tests/check.py --php C:\path\to\php.exe` untuk pemeriksaan HTTP dan `php tests/database_check.php` untuk seed, relasi, enkripsi, serta cascade. Jika PHP Anda memiliki ekstensi MySQL yang tersedia tetapi belum aktif, tambahkan `--php-arg=-d --php-arg=extension=pdo_mysql` pada tes Python dan jalankan tes database dengan `php -d extension=pdo_mysql tests/database_check.php`. Pengujian migrasi dilakukan pada MySQL 8 menggunakan `php artisan migrate:fresh --seed`.
