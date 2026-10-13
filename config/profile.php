<?php
return [
    'nama' => env('PROFILE_NAME', 'Marco Marcello Hugo'),
    'nrp' => env('PROFILE_NRP', '5025221102'),
    'departemen' => 'Teknik Informatika',
    'kampus' => 'Institut Teknologi Sepuluh Nopember',
    'tema' => env('PROJECT_THEME', 'ResearchMate AI'),
    'deskripsi' => 'Ruang kerja penelitian untuk merumuskan pertanyaan, mencatat jumlah sumber, meninjau langkah awal, dan menyimpan rencana ke akun.',
    'ai' => [
        'fase' => 'Perencanaan riset',
        'capaian' => 'Membantu peneliti menyiapkan sumber dan memeriksa langkah awal riset.',
        'skenario' => [
            ['judul' => 'Planner', 'bukti' => 'Pertanyaan riset menjadi titik awal rencana kerja.', 'saran' => 'Uraikan pertanyaan, tujuan, dan kriteria sumber sebelum menelusuri artikel.', 'mode' => 'semua'],
            ['judul' => 'Discovery', 'bukti' => 'Artikel dan PDF perlu dicatat bersama metadata asalnya.', 'saran' => 'Gunakan kata kunci yang relevan dan simpan sumber untuk diverifikasi.', 'mode' => 'jelajah'],
            ['judul' => 'Analysis', 'bukti' => 'Metode dan hasil tiap sumber dapat dibandingkan.', 'saran' => 'Bangun matriks literatur sebelum menyatakan adanya celah riset.', 'mode' => 'telaah'],
            ['judul' => 'Synthesis', 'bukti' => 'Temuan dari beberapa sumber dapat dikelompokkan.', 'saran' => 'Rangkum persamaan dan perbedaan tanpa menghilangkan konteks studi.', 'mode' => 'telaah'],
            ['judul' => 'Research Gap', 'bukti' => 'Pertanyaan yang belum terjawab memerlukan dukungan literatur.', 'saran' => 'Catat kandidat celah riset dan sumber yang mendasarinya.', 'mode' => 'telaah'],
            ['judul' => 'Verification', 'bukti' => 'Kesimpulan perlu mengacu ke sumber yang dapat dibuka ulang.', 'saran' => 'Periksa kutipan dan klaim terhadap dokumen aslinya.', 'mode' => 'telaah'],
        ],
    ],
];
