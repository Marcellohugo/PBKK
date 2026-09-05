<?php
return [
    'nama' => env('PROFILE_NAME', 'Marco Marcello Hugo'),
    'nrp' => env('PROFILE_NRP', '5025221102'),
    'departemen' => 'Teknik Informatika',
    'kampus' => 'Institut Teknologi Sepuluh Nopember',
    'tema' => env('PROJECT_THEME', 'Narafin AI Coach — Saran Analitika Pemain'),
    'deskripsi' => 'Rencana asisten AI untuk menjelaskan hasil permainan Cashflowpoly dan menyusun saran yang mempertimbangkan kas, pemakaian bahan, serta pinjaman sesuai mode permainan.',
    'ai' => [
        'minggu' => 1,
        'fase' => 'Konsep dan pemetaan masalah',
        'capaian' => 'Mengidentifikasi kebutuhan saran kontekstual dari Analitika Pemain Narafin.',
        'sumber' => 'https://narafin.org',
        'indikator' => ['kas' => 'Perubahan koin dari awal', 'bahan' => 'Persentase bahan yang terpakai', 'pinjaman' => 'Pinjaman belum lunas (Mahir)'],
    ],
];
