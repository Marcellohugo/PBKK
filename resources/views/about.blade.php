@extends('layouts.app')
@section('title', 'Tentang')
@section('content')
<div class="max-w-4xl border-b border-slate-200/80 pb-6 dark:border-slate-800/80">
    <div class="badge-its">
        Tentang Aplikasi & Kurikulum
    </div>
    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl">Profil dan proyek PBKK</h1>
    <p class="mt-4 text-base leading-relaxed text-slate-600 dark:text-slate-300">
        Aplikasi ini menampilkan profil mahasiswa, rancangan Narafin AI Coach, kalkulator, dan formulir masukan dengan Laravel.
    </p>
</div>

<div class="mt-8 grid gap-6 md:grid-cols-2">
    <div class="rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33]">
        <p class="eyebrow">Institusi & Program</p>
        <h2 class="mt-2 text-xl font-bold tracking-tight text-slate-900 dark:text-white">Teknik Informatika ITS</h2>
        <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-300">
            Departemen Teknik Informatika di Institut Teknologi Sepuluh Nopember, Surabaya, mengintegrasikan rekayasa perangkat lunak modern, kecerdasan buatan, dan arsitektur kerangka kerja web.
        </p>
    </div>

    <div class="rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33]">
        <p class="eyebrow">Evolusi Proyek</p>
        <h2 class="mt-2 text-xl font-bold tracking-tight text-slate-900 dark:text-white">Perkembangan Bertahap</h2>
        <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-300">
            Dikembangkan secara bertahap dari branch W1 (konsep & routing) hingga W4 (Blade template modern & Vite asset bundler) dengan arsitektur MVC terstandarisasi.
        </p>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-4">
    <a class="button" href="{{ route('profile') }}">
        <span>Lihat profil</span>
        <span aria-hidden="true">→</span>
    </a>
    <a class="button-secondary" href="{{ route('project') }}">
        <span>Baca ide proyek</span>
    </a>
</div>
@endsection

