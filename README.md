# Narafin AI Coach

Narafin AI Coach membantu instruktur Cashflowpoly meninjau kas, pemakaian bahan, dan pinjaman pemain. Hasil analitika menyertakan angka yang menjadi dasar setiap saran, sehingga instruktur dapat memeriksanya sebelum berdiskusi dengan pemain.

Analitika yang tersedia saat ini berbasis aturan dari metrik yang dimasukkan pengguna. Integrasi model bahasa dan sinkronisasi data permainan belum tersedia.

## Menjalankan lokal

Butuh PHP 8.3+ dengan ekstensi `pdo_pgsql`, Composer, Node.js, dan Docker Compose (atau PostgreSQL 16 yang sudah berjalan). Konfigurasi contoh memakai PostgreSQL pada `127.0.0.1:5436` dengan volume persisten.

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

Jika memakai PostgreSQL sendiri, ubah `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` dalam `.env`. Pada komputer pengembangan ini, `. .\dev-env.ps1` mengaktifkan runtime PHP dan ekstensi PostgreSQL. Untuk server dengan helper tersebut, jalankan `Set-Location public` lalu `php -S 127.0.0.1:8006 ..\vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php` agar ekstensi tetap aktif pada proses server.

Aplikasi tersedia di `http://127.0.0.1:8006`. Akun demo: `dosenpbkk@its.ac.id` dengan kata sandi `demo12345`. Akun dan kata sandi ini hanya untuk data lokal hasil seeding. Pendaftaran mandiri saat ini dibatasi ke alamat `@student.its.ac.id`.

## Fitur

- Akun pengguna, login, dan dashboard berisi proyek milik pengguna yang sedang masuk, diurutkan dari yang terbaru.
- Analitika sesi mode Pemula dan Mahir, validasi metrik, dan saran yang menampilkan bukti angka.
- Formulir masukan dengan verifikasi sederhana, validasi, dan penyimpanan di PostgreSQL.
- Relasi `users`–`projects` dengan email unik dan cascade delete. API key proyek menggunakan cast terenkripsi dan tidak ditampilkan di antarmuka.
- Seeder membuat 15 akun uji dengan dua proyek per akun serta satu akun demo dengan dua proyek.

Penjelasan sumber metrik dan batas sistem ada di [docs/narafin-ai.md](docs/narafin-ai.md). `.env`, `vendor/`, dan `node_modules/` diabaikan Git.

## Verifikasi

```powershell
php tests/database_check.php
python tests/check.py --php C:\path\to\php.exe
```

Jika ekstensi PostgreSQL tersedia tetapi belum aktif pada PHP CLI, tambahkan `-d extension=pdo_pgsql` pada perintah PHP, atau `--php-arg=-d --php-arg=extension=pdo_pgsql` pada tes Python. Gunakan `php artisan migrate:fresh --seed` hanya pada database pengembangan yang boleh direset.
