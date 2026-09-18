# W3 — Secure Feedback Hub

Marco Marcello Hugo · 5025221102

Sumber: `pertemuan_3_lengkap-ok.pptx`, slide 41–45 (nomor urut file).

Tema proyek: **Narafin AI Coach — Saran Analitika Pemain**. Tahap W3: evaluasi saran dengan mode/indikator dan validasi form. Dasarnya adalah bagian Saran pada Analitika Pemain Cashflowpoly di [Narafin](https://narafin.org). Detail sumber, batas implementasi, dan perkembangan W1–W4 ada di [rencana AI](docs/narafin-ai.md).

## Menjalankan

Dari root proyek, aktifkan runtime lokal dengan `. .\dev-env.ps1`, lalu:

```powershell
php artisan serve --host=127.0.0.1 --port=8003
```

Buka http://127.0.0.1:8003. Dependensi dan `.env` sudah disiapkan di komputer ini. Untuk instalasi baru, jalankan `composer install`, salin `.env.example` ke `.env`, kemudian `php artisan key:generate`.

## Pemetaan tugas dan challenge

| Ketentuan | Implementasi |
| --- | --- |
| Arsitektur | Semua GET/POST melalui PageController, named routes |
| Nama | Wajib, string, minimal 3, maksimal 100 karakter |
| Email | Wajib, email valid, domain persis student.its.ac.id |
| Kategori | Allowlist Akademik, Sarana Prasarana, Kegiatan Mahasiswa |
| Pesan | Wajib, string, minimal 15, maksimal 5000 karakter |
| Keamanan dan UX | @csrf, pesan Indonesia per field, old() pada input/textarea/select |
| CAPTCHA | Dua angka random_int() dalam sesi, validasi server, dibuang setelah sukses |
| Tampilan | Bootstrap CDN, formulir dan konfirmasi sukses responsif |
| Konteks Narafin opsional | Masukan akademik umum diterima tanpa mode/indikator; keduanya divalidasi jika diisi |

## Urutan demo

1. Buka `/`, isi empat field wajib dan jawab CAPTCHA. Kirim masukan akademik umum tanpa konteks Narafin.
   Untuk evaluasi permainan, isi mode dan indikator sekaligus. Pilihan pinjaman pada Pemula ditolak.
2. Perlihatkan konfirmasi sukses serta isian yang sudah di-escape.
3. Kirim email di luar domain ITS atau CAPTCHA salah untuk menunjukkan error dan old input.
4. Jalankan pengujian W3 untuk membuktikan POST tanpa token/memakai token salah menghasilkan HTTP 419.

## Pengujian dan screenshot

Jalankan `python tests/check.py` setelah mengaktifkan runtime, atau `python tests/check.py --php C:\path\to\php.exe`. Tes menyesuaikan minggu dengan branch dan memeriksa fitur Laravel serta konteks saran Narafin.

Screenshot aplikasi saat ini: [desktop](docs/desktop.png) dan [mobile](docs/mobile.png).

Data form hanya ditampilkan melalui flash session pada konfirmasi setelah redirect, tanpa database atau pengiriman eksternal. Refresh konfirmasi berikutnya dapat menghapus data flash.

## Berkas utama

- `routes/web.php`: deklarasi rute.
- `app/Http/Controllers/PageController.php`: penanganan request.
- `resources/views/`: Blade layout dan halaman.
- `config/profile.php`: identitas dan usulan tema.

`.env` dan `vendor/` dikecualikan oleh `.gitignore`. Pengunggahan GitHub dan pengumpulan LMS dilakukan terpisah oleh pemilik tugas.
