@extends('layouts.app')
@section('title', 'Tentang')
@section('content')
<div class="max-w-4xl">
    <span class="badge-its">Tentang ITS Academic</span>
    <h1 class="mt-4 text-4xl font-extrabold tracking-tight">Ruang akademik dan proyek penelitian</h1>
    <p class="mt-4 text-slate-600 dark:text-slate-300">Portal ini menyediakan profil akademik, alat hitung, masukan pengguna, dan ResearchMate AI. Melalui ResearchMate, pengguna dapat meninjau rencana riset lalu menyimpannya sebagai proyek pribadi.</p>
    <div class="mt-8 grid gap-4 md:grid-cols-2">
        <x-info-card title="Teknik Informatika ITS" label="Institusi">Departemen Teknik Informatika ITS di Surabaya menjadi ruang belajar dan riset mahasiswa, termasuk perencanaan proyek berbasis komputasi.</x-info-card>
        <x-info-card title="ResearchMate AI" label="Riset">Tinjauan awal dibuat dari pertanyaan dan jumlah sumber yang dicatat. Artikel dan dokumen asli tetap perlu diperiksa peneliti.</x-info-card>
    </div>
    <section class="mt-8 feature-card">
        <p class="eyebrow">Cara menggunakan</p><h2 class="mt-2 text-xl font-bold">Mulai dari pertanyaan riset</h2>
        <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">Catat pertanyaan dan jumlah sumber, tinjau saran awal, lalu simpan rencana ke akun Anda. Buka kembali hasilnya dari Proyek Saya.</p>
        <div class="mt-5 flex flex-wrap gap-3"><a class="text-link" href="{{ route('profile') }}">Lihat profil akademik →</a><a class="text-link" href="{{ route('idea') }}">Mulai ResearchMate →</a></div>
    </section>
</div>
@endsection
