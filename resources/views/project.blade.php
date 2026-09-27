@extends('layouts.app')
@section('title', 'Ide Proyek')
@section('content')
<div class="max-w-4xl border-b border-slate-200/80 pb-6 dark:border-slate-800/80">
    <div class="badge-its">
        Usulan Agentic AI
    </div>
    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl">{{ $profil['tema'] }}</h1>
    <p class="mt-4 text-base leading-relaxed text-slate-600 dark:text-slate-300">{{ $profil['deskripsi'] }}</p>
</div>

<div class="mt-8">
    <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Arsitektur Aliran Data & Keputusan</h2>
    <div class="mt-6 grid gap-6 md:grid-cols-3">
        <x-info-card title="Masukan" label="Data" class="border-t-4 border-t-[#013880]">
            <p class="leading-relaxed">Instruktur memilih pemain, sesi, dan mode permainan.</p>
        </x-info-card>
        <x-info-card title="Analisis" label="Proses" class="border-t-4 border-t-[#f8ac18]">
            <p class="leading-relaxed">Aplikasi menghitung kas, penggunaan bahan, dan pinjaman yang tersedia.</p>
        </x-info-card>
        <x-info-card title="Saran" label="Keluaran" class="border-t-4 border-t-[#001e3d] dark:border-t-sky-400">
            <p class="leading-relaxed">Hasil berbasis bukti disajikan untuk ditinjau instruktur.</p>
        </x-info-card>
    </div>
</div>

<div class="mt-8 pt-6 border-t border-slate-200/80 dark:border-slate-800/80 flex flex-wrap gap-4">
    <a class="button" href="{{ route('idea') }}">
        <span>Lihat rancangan dan demo</span>
        <span aria-hidden="true">→</span>
    </a>
    <a class="button-secondary" href="{{ route('agent') }}">
        <span>Jelajahi skenario agent</span>
    </a>
</div>
@endsection

