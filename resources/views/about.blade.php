@extends('layouts.app')
@section('title', 'Tentang')
@section('content')
<div class="max-w-4xl">
    <span class="badge-its">Tentang Portal PBKK</span>
    <h1 class="mt-4 text-4xl font-extrabold tracking-tight">Ruang akademik dan proyek penelitian</h1>
    <p class="mt-4 text-slate-600 dark:text-slate-300">Portal ini menghubungkan profil mahasiswa, kalkulator, formulir masukan, dan ResearchMate AI. Melalui ResearchMate, pengguna dapat meninjau rencana riset serta melihat proyek yang terhubung dengan akunnya.</p>
    <div class="mt-8 grid gap-4 md:grid-cols-2">
        <x-info-card title="Teknik Informatika ITS" label="Institusi">Portal akademik ini dikembangkan dalam konteks Pemrograman Berbasis Kerangka Kerja di Institut Teknologi Sepuluh Nopember.</x-info-card>
        <x-info-card title="ResearchMate AI" label="Proyek">Tinjauan awal riset membantu merencanakan kerja; artikel dan dokumen asli tetap perlu diperiksa oleh peneliti.</x-info-card>
    </div>
    <section class="mt-8 feature-card">
        <p class="eyebrow">Asal pengembangan</p><h2 class="mt-2 text-xl font-bold">Teknik Informatika ITS</h2>
        <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">Portal ini dikembangkan oleh {{ config('profile.nama') }} ({{ config('profile.nrp') }}) di Departemen Teknik Informatika ITS, Surabaya.</p>
        <div class="mt-5 flex flex-wrap gap-3"><a class="text-link" href="{{ route('profile') }}">Lihat profil →</a><a class="text-link" href="{{ route('idea') }}">Jelajahi ResearchMate →</a></div>
    </section>
</div>
@endsection
