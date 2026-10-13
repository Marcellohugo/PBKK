# ITS Academic · ResearchMate AI

ITS Academic memuat profil akademik, kalkulator, masukan pengguna, dan ResearchMate AI untuk merencanakan riset. Di ResearchMate, pengguna menulis pertanyaan, meninjau kesiapan literatur, masuk atau mendaftar, lalu menyimpan rencana sebagai proyek pribadi yang dapat dibuka lagi. Tinjauan menggunakan aturan dari input pengguna; pembacaan PDF, pencarian artikel otomatis, dan panggilan model AI belum tersedia.

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
- Alur rencana riset sampai penyimpanan proyek; draf disimpan dalam sesi ketika pengguna perlu masuk atau mendaftar. Rencana tersimpan dapat dibuka dari dashboard, dan pengguna dapat memulai rencana baru tanpa membawa draf sebelumnya.
- Relasi `users`–`projects`, email unik, penghapusan berantai, proteksi mass assignment, dan cast terenkripsi untuk API key.
- Formulir rencana riset dengan validasi, hasil berbasis input, dan penjelasan bukti angka. Pertanyaan serta jumlah sumber disimpan bersama proyek.
- Formulir masukan dengan validasi server, perlindungan CSRF, pemulihan input lama, dan tantangan matematika berbasis sesi.
- Halaman profil mahasiswa, konsep ResearchMate, kalkulator, dan IPK.

Seeder menyediakan 15 akun mahasiswa dengan dua proyek riset per akun serta akun demo dengan dua proyek. `.env`, `vendor/`, dan `node_modules/` diabaikan Git.

## Verifikasi

```powershell
php tests/database_check.php
python tests/check.py --php C:\path\to\php.exe
```

Lihat [batas fitur saat ini](docs/researchmate.md) untuk perbedaan antara konsep platform ResearchMate dan fitur yang sudah dapat dijalankan di aplikasi ini.
