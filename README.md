# ResearchMate AI

ResearchMate AI adalah ruang kerja penelitian untuk merencanakan pertanyaan riset, meninjau kesiapan literatur, dan melihat proyek yang terhubung dengan akun pengguna. Antarmuka serta alur produk mengacu pada project Researchmate. Tinjauan rencana yang tersedia di aplikasi ini menggunakan aturan dari input pengguna; pembacaan PDF, pencarian artikel otomatis, dan panggilan model AI belum tersedia di implementasi ini.

## Menjalankan lokal

Butuh PHP 8.3+ dengan ekstensi `pdo_pgsql`, Composer, Node.js, dan PostgreSQL 16. Konfigurasi contoh menggunakan Docker Compose pada port 5436.

```powershell
docker compose up -d --wait
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
npm ci
npm run build
php artisan serve --host=127.0.0.1 --port=8006
```

Atur `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` pada `.env` bila memakai PostgreSQL lain. Di komputer pengembangan ini, `. .\dev-env.ps1` mengaktifkan runtime PHP dan ekstensi PostgreSQL. Akun data contoh: `dosenpbkk@its.ac.id` dengan kata sandi `demo12345`; gunakan hanya untuk pengembangan lokal.

## Fitur

- Registrasi, login, dan dashboard yang hanya menampilkan proyek milik akun aktif, terbaru lebih dulu.
- Relasi `users`–`projects`, email unik, penghapusan berantai, proteksi mass assignment, dan cast terenkripsi untuk API key.
- Formulir rencana riset dengan validasi, hasil berbasis input, dan penjelasan bukti angka.
- Formulir masukan dengan validasi server, perlindungan CSRF, pemulihan input lama, dan tantangan matematika berbasis sesi.
- Halaman profil tim, konsep produk, kalkulator, dan IPK.

Seeder menyediakan 15 akun mahasiswa dengan dua proyek riset per akun serta akun demo dengan dua proyek. `.env`, `vendor/`, dan `node_modules/` diabaikan Git.

## Verifikasi

```powershell
php tests/database_check.php
python tests/check.py --php C:\path\to\php.exe
```

Lihat [batas fitur saat ini](docs/researchmate.md) untuk perbedaan antara konsep platform ResearchMate dan fitur yang sudah dapat dijalankan di aplikasi ini.
