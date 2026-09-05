# Narafin AI Coach — W1

Tema ini dikembangkan dari bagian **Saran** pada **Analitika Pemain pada Sesi** di [Narafin](https://narafin.org), yang dibaca pada 29 September 2026. Narafin adalah dashboard analitika permainan Cashflowpoly. Halaman sumber memerlukan login; kredensial tidak disimpan dalam proyek ini.

## Masalah dan rencana AI

Saran yang ada berkaitan dengan perubahan koin, pemerataan pemasukan, biaya dan pemakaian bahan, keuntungan pesanan, pinjaman, risiko, target finansial, penggunaan aksi, kebutuhan, donasi, serta sumber poin kebahagiaan. Rencana AI adalah merangkai indikator tersebut menjadi penjelasan yang sesuai konteks pemain dan menyebut bukti dari metrik, bukan sekadar satu pesan untuk satu angka.

Perhitungan tetap dilakukan oleh aplikasi. LLM direncanakan menerima ringkasan metrik, mode permainan, dan aturan sesi, lalu menyusun penjelasan serta langkah yang dapat ditinjau instruktur. AI tidak melakukan aksi permainan atau transaksi.

- Pisahkan Pemula dan Mahir; pinjaman dan risiko tidak diterapkan pada Pemula.
- Pertahankan data tidak tersedia sebagai nilai kosong, bukan nol.
- Jelaskan penyebab dan kaitan antarmetrik, dengan kas dan kewajiban sebagai pertimbangan awal.
- Gunakan bahasa evaluasi keputusan permainan, bukan penilaian kemampuan finansial pemain.

## Perkembangan W1–W4

| Branch | Fitur tahap tersebut | Langkah berikutnya |
| --- | --- | --- |
| w1 | Identifikasi masalah, sumber, input, dan alur AI pada halaman ide | Memetakan saran menurut mode |
| w2 | Routing dan pilihan mode untuk melihat skenario kas, bahan, dan pinjaman | Mengumpulkan evaluasi saran |
| w3 | Form evaluasi saran dengan mode/indikator, validasi ITS, CSRF, dan CAPTCHA | Mengolah metrik dari form |
| w4 | Demo input metrik, saran dengan bukti angka, prioritas pinjaman, dan data kosong | Integrasi LLM serta metrik Narafin yang berizin |

**Tahap branch ini: W1 — Konsep dan pemetaan masalah.** Mengidentifikasi kebutuhan saran kontekstual dari Analitika Pemain Narafin.

Contoh pada proyek adalah data simulasi yang dibuat untuk latihan, bukan rekaman pribadi pemain Narafin. Demo W4 menggunakan aturan deterministik sebagai dasar sebelum integrasi LLM. Tidak ada panggilan API AI, sinkronisasi Narafin, atau klaim bahwa model sudah berjalan.
