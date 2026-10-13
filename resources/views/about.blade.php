@extends('layouts.app')
@section('title', 'Tentang')
@section('content')
<div class="max-w-4xl">
    <span class="badge-its">Tentang ResearchMate</span>
    <h1 class="mt-4 text-4xl font-extrabold tracking-tight">Ruang kerja untuk penelitian yang dapat diperiksa</h1>
    <p class="mt-4 text-slate-600 dark:text-slate-300">ResearchMate AI dirancang untuk membantu peneliti menata proyek, menelusuri literatur, membandingkan temuan, dan menyiapkan laporan dengan rujukan yang jelas. Versi aplikasi ini menyediakan akun, daftar proyek pribadi, formulir masukan, dan tinjauan rencana riset berbasis aturan.</p>
    <div class="mt-8 grid gap-4 md:grid-cols-2">
        <x-info-card title="Tinjau sumber asli" label="Metode">Setiap klaim riset perlu diperiksa terhadap artikel atau dokumen yang mendukungnya.</x-info-card>
        <x-info-card title="Kendalikan proses" label="Peneliti">Hasil tinjauan awal membantu merencanakan kerja; keputusan penelitian tetap pada pengguna.</x-info-card>
    </div>
    <section class="mt-8 feature-card">
        <p class="eyebrow">Asal pengembangan</p><h2 class="mt-2 text-xl font-bold">Teknik Informatika ITS</h2>
        <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">Departemen Teknik Informatika, Institut Teknologi Sepuluh Nopember, Surabaya, mengembangkan keilmuan komputasi dan sistem informasi. Aplikasi ini dikembangkan oleh {{ config('profile.nama') }} ({{ config('profile.nrp') }}).</p>
        <div class="mt-5 flex flex-wrap gap-3"><a class="text-link" href="{{ route('project') }}">Lihat konsep produk →</a><a class="text-link" href="{{ route('calculator') }}">Alat hitung →</a></div>
    </section>
</div>
@endsection
