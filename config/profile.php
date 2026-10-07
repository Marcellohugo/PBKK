<?php
return [
    'nama' => env('PROFILE_NAME', 'Marco Marcello Hugo'),
    'nrp' => env('PROFILE_NRP', '5025221102'),
    'departemen' => 'Teknik Informatika',
    'kampus' => 'Institut Teknologi Sepuluh Nopember',
    'tema' => env('PROJECT_THEME', 'Narafin AI Coach — Saran Analitika Pemain'),
    'deskripsi' => 'Analitika sesi Cashflowpoly yang menjelaskan perubahan kas, pemakaian bahan, dan pinjaman sesuai mode permainan dengan bukti angka yang dapat diperiksa.',
    'ai' => [
        'fase' => 'Analitika berbasis metrik',
        'capaian' => 'Mengolah metrik sesi menjadi saran dengan bukti angka dan prioritas yang jelas.',
        'sumber' => 'https://narafin.org',
        'skenario' => [
            ['indikator' => 'kas', 'judul' => 'Kas menurun', 'bukti' => 'Contoh simulasi: koin awal 20, koin akhir 12; perubahan kas -40%.', 'saran' => 'Tinjau pengeluaran terbesar dan pilih aksi yang menghasilkan koin sebelum menambah belanja.', 'mode' => 'semua'],
            ['indikator' => 'bahan', 'judul' => 'Bahan belum banyak terpakai', 'bukti' => 'Contoh simulasi: 4 dari 10 kartu bahan dipakai; pemakaian 40%.', 'saran' => 'Gunakan persediaan untuk pesanan berikutnya sebelum membeli bahan baru.', 'mode' => 'semua'],
            ['indikator' => 'pinjaman', 'judul' => 'Masih ada pinjaman', 'bukti' => 'Contoh simulasi: sisa pokok pinjaman 6 koin pada mode Mahir.', 'saran' => 'Susun pelunasan sesuai kas yang tersedia karena pinjaman belum lunas memengaruhi poin kebahagiaan.', 'mode' => 'mahir'],
        ],
        'indikator' => ['kas' => 'Perubahan koin dari awal', 'bahan' => 'Persentase bahan yang terpakai', 'pinjaman' => 'Pinjaman belum lunas (Mahir)'],
    ],
];
