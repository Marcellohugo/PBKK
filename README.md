# ITS Academic · ResearchMate AI

ITS Academic memuat profil akademik, kalkulator, masukan pengguna, dan ResearchMate AI untuk merencanakan riset. Pengguna menulis pertanyaan, meninjau kesiapan literatur, lalu menyimpan rencana sebagai proyek pribadi. Panel AdminLTE membantu Admin dan Staf memantau proyek dengan hak akses berbeda. Tinjauan ResearchMate masih berbasis aturan dari input pengguna; pembacaan PDF, pencarian artikel otomatis, dan panggilan model AI belum tersedia.

## Menjalankan lokal

Butuh PHP 8.3+ dengan ekstensi `pdo_pgsql`, Composer, Node.js, dan PostgreSQL 16. Konfigurasi contoh menggunakan Docker Compose pada port 5436.

```powershell
docker compose up -d --wait
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
npm ci
php artisan adminlte:install --only=assets --only=vendor_assets --only=translations
npm run build
php artisan serve --host=127.0.0.1 --port=8010
```

Atur `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` pada `.env` bila memakai PostgreSQL lain. Di komputer pengembangan ini, `. .\dev-env.ps1` mengaktifkan runtime PHP dan ekstensi PostgreSQL. Jalankan `php artisan adminlte:status` untuk memeriksa aset panel yang sudah disertakan. Buka `/admin/dashboard` setelah masuk sebagai Admin atau Staf.

| Akun uji lokal | Email | Kata sandi | Akses |
| --- | --- | --- | --- |
| Admin | `admin@researchmate.local` | `demo12345` | Lihat semua proyek dan hapus data |
| Staf | `staf@researchmate.local` | `demo12345` | Lihat dan cari proyek, tanpa hapus |
| Peneliti | `dosenpbkk@its.ac.id` | `demo12345` | Proyek pribadi |

Pada lingkungan `local` di `127.0.0.1`, halaman login menyediakan tombol masuk instan Admin dan Staf. Seeder hanya membuat akun dan proyek contoh pada lingkungan `local`; pada lingkungan lain ia hanya menyiapkan role dan permission. Untuk memberi peran pada akun nyata setelah registrasi, jalankan `php artisan tinker` lalu `\App\Models\User::where('email', 'alamat@domain')->firstOrFail()->assignRole('Admin');` (atau `Staf`).

## Fitur

- Registrasi, login, dan dashboard yang hanya menampilkan proyek milik akun aktif, terbaru lebih dulu.
- Alur rencana riset sampai penyimpanan proyek; draf disimpan dalam sesi ketika pengguna perlu masuk atau mendaftar. Rencana tersimpan dapat dibuka dari dashboard, dan pengguna dapat memulai rencana baru tanpa membawa draf sebelumnya.
- Relasi `users`–`projects`, email unik, penghapusan berantai, proteksi mass assignment, dan cast terenkripsi untuk API key.
- Formulir rencana riset dengan validasi, hasil berbasis input, dan penjelasan bukti angka. Pertanyaan serta jumlah sumber disimpan bersama proyek.
- Formulir masukan dengan validasi server, perlindungan CSRF, pemulihan input lama, dan tantangan matematika berbasis sesi.
- Halaman profil mahasiswa, konsep ResearchMate, kalkulator, dan IPK.
- Panel AdminLTE dengan autentikasi bergaya Laravel Breeze, role dan permission Spatie, tiga statistik `count()` dari database, tabel proyek dengan pencarian `when()` dan pagination yang mempertahankan kueri, serta penghapusan khusus Admin pada tampilan dan server.

Seeder lokal menyediakan 15 akun mahasiswa dengan dua proyek riset per akun serta akun demo. `.env`, `vendor/`, dan `node_modules/` diabaikan Git.

![Dashboard Admin ResearchMate](docs/images/admin-dashboard.jpg)

## Verifikasi

```powershell
php tests/database_check.php
python tests/check.py --week 10 --php C:\path\to\php.exe
```

Lihat [batas fitur saat ini](docs/researchmate.md) untuk perbedaan antara konsep platform ResearchMate dan fitur yang sudah dapat dijalankan di aplikasi ini.
