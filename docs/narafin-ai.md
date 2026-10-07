# Analitika Narafin AI Coach

Narafin AI Coach berfokus pada bagian **Saran** dari **Analitika Pemain pada Sesi** di [Narafin](https://narafin.org). Halaman sumber memerlukan login; kredensial sumber tidak disimpan di aplikasi ini. Contoh metrik dalam aplikasi merupakan data ilustrasi, bukan rekaman pribadi pemain.

## Alur saat ini

Instruktur memilih mode Pemula atau Mahir dan memasukkan koin awal/akhir, bahan terkumpul/terpakai, serta sisa pinjaman untuk mode Mahir. Aplikasi memvalidasi input, menghitung perubahan kas dan persentase pemakaian bahan, kemudian menyusun saran yang menyebut bukti angkanya. Nilai yang belum tersedia tetap kosong dan tidak dianggap nol. Mode Pemula tidak memproses pinjaman.

Hasil saat ini diturunkan dari aturan deterministik. Tidak ada panggilan LLM, sinkronisasi dengan Narafin, aksi permainan, atau transaksi otomatis. Instruktur perlu meninjau saran dalam konteks sesi.

## Arah pengembangan

Saran berikutnya dapat menghubungkan perubahan koin, pemerataan pemasukan, biaya dan penggunaan bahan, keuntungan pesanan, pinjaman, risiko, target finansial, penggunaan aksi, kebutuhan, donasi, serta sumber poin kebahagiaan. Model bahasa dapat menerima ringkasan metrik yang diizinkan untuk menjelaskan hubungan antarmetrik, sementara perhitungan tetap dilakukan oleh aplikasi dan hasilnya tetap ditinjau instruktur.
