@extends('layouts.app')
@section('title', 'Profil Mahasiswa')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200/80 pb-6 dark:border-slate-800/80">
    <div class="flex items-center gap-4">
        <div class="grid h-16 w-16 place-items-center rounded-lg bg-[#013880] text-2xl font-black text-white shadow-xs border-2 border-[#f8ac18]">
            MH
        </div>
        <div>
            <p class="eyebrow">Profil Mahasiswa</p>
            <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl">{{ $profil['nama'] }}</h1>
            <p class="mt-0.5 text-sm font-semibold text-slate-500 dark:text-slate-400">NRP {{ $profil['nrp'] }} · {{ $profil['departemen'] }}</p>
        </div>
    </div>
    <span class="badge-its">
        Status: Mahasiswa Aktif
    </span>
</div>

<div class="mt-8 grid gap-6 md:grid-cols-2">
    <x-info-card title="Identitas akademik" label="Biodata Resmi">
        <dl class="space-y-3 divide-y divide-slate-100 dark:divide-slate-800 text-sm">
            <div class="pt-2 flex justify-between items-center">
                <dt class="font-bold text-slate-700 dark:text-slate-300">NRP</dt>
                <dd class="font-mono font-bold text-[#013880] dark:text-sky-300">{{ $profil['nrp'] }}</dd>
            </div>
            <div class="pt-3 flex justify-between items-center">
                <dt class="font-bold text-slate-700 dark:text-slate-300">Departemen</dt>
                <dd class="font-semibold text-slate-900 dark:text-white">{{ $profil['departemen'] }}</dd>
            </div>
            <div class="pt-3 flex justify-between items-center">
                <dt class="font-bold text-slate-700 dark:text-slate-300">Fakultas</dt>
                <dd class="font-semibold text-slate-900 dark:text-white">FTEIC</dd>
            </div>
            <div class="pt-3 flex justify-between items-center">
                <dt class="font-bold text-slate-700 dark:text-slate-300">Perguruan tinggi</dt>
                <dd class="font-semibold text-slate-900 dark:text-white">{{ $profil['kampus'] }}</dd>
            </div>
        </dl>
    </x-info-card>

    <x-info-card :title="$profil['tema']" label="Rencana Proyek Akhir">
        <p class="leading-relaxed">{{ $profil['deskripsi'] }}</p>
        <div class="mt-5 pt-3 border-t border-slate-100 dark:border-slate-800">
            <a class="text-link" href="{{ route('idea') }}">
                <span>Lihat alur rancangan & demo</span>
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </x-info-card>
</div>

<x-info-card class="mt-6 border-t-3 border-t-[#013880]" title="Riwayat belajar" label="Kurikulum Praktikum PBKK">
    <p class="mb-4 text-xs font-semibold text-slate-500 dark:text-slate-400">Rangkuman capaian modul pembelajaran pada mata kuliah Pemrograman Berbasis Kerangka Kerja.</p>
    <ul class="space-y-2.5 text-sm">
        @foreach($riwayat as $item)
        <li class="flex items-start gap-3">
            <span class="mt-0.5 grid h-4 w-4 shrink-0 place-items-center rounded-full bg-blue-100 text-[10px] font-bold text-[#013880] dark:bg-blue-950 dark:text-sky-300">✓</span>
            <span class="text-slate-700 dark:text-slate-300 leading-relaxed">{{ $item }}</span>
        </li>
        @endforeach
    </ul>

    {{-- Detail Capaian Progres Sprint W1 - W4 --}}
    <div class="mt-6 pt-5 border-t border-slate-200/80 dark:border-slate-800">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-3">
            Matriks Progres Sprint Mingguan (Branch w1 &rarr; w4)
        </p>
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border border-slate-200 bg-slate-50/60 p-3 dark:border-slate-800 dark:bg-slate-900/40">
                <span class="font-mono text-[10px] font-bold text-[#013880] dark:text-sky-300 uppercase">Sprint W1</span>
                <p class="mt-1 text-xs font-bold text-slate-900 dark:text-white">Arsitektur MVC Dasar</p>
                <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">Rute Controller, Profil Jurusan, & Kalkulator 4 Operasi</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-slate-50/60 p-3 dark:border-slate-800 dark:bg-slate-900/40">
                <span class="font-mono text-[10px] font-bold text-amber-700 dark:text-amber-300 uppercase">Sprint W2</span>
                <p class="mt-1 text-xs font-bold text-slate-900 dark:text-white">Parameter & Regex</p>
                <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">Regex 10-Digit NRP, Named Routes, & Kalkulator IPK</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-slate-50/60 p-3 dark:border-slate-800 dark:bg-slate-900/40">
                <span class="font-mono text-[10px] font-bold text-sky-700 dark:text-sky-300 uppercase">Sprint W3</span>
                <p class="mt-1 text-xs font-bold text-slate-900 dark:text-white">Form & Sesi Captcha</p>
                <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">CSRF Security, Validasi Email ITS, & Session Captcha</p>
            </div>
            <div class="rounded-lg border border-blue-200 bg-blue-50/60 p-3 dark:border-blue-900 dark:bg-blue-950/40">
                <span class="font-mono text-[10px] font-bold text-[#013880] dark:text-sky-300 uppercase">Sprint W4 (Aktif)</span>
                <p class="mt-1 text-xs font-bold text-slate-900 dark:text-white">Layout, Vite & AI</p>
                <p class="mt-1 text-[11px] text-slate-600 dark:text-slate-300">Blade Components, Vite Bundler, & Narafin AI Coach</p>
            </div>
        </div>
    </div>
</x-info-card>

<section id="tentang" class="mt-12 scroll-mt-10 rounded-xl border border-slate-200/90 bg-white p-7 shadow-xs dark:border-slate-800 dark:bg-[#0b1c33]">
    <p class="eyebrow">Informasi Institusi</p>
    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Teknik Informatika ITS</h2>
    <p class="mt-4 max-w-3xl leading-relaxed text-slate-600 dark:text-slate-300">
        Departemen Teknik Informatika berada di Institut Teknologi Sepuluh Nopember, Surabaya. Bidang pembelajarannya mencakup pemrograman, algoritma, rekayasa perangkat lunak, basis data, jaringan komputer, dan kecerdasan buatan. Dalam PBKK, saya menerapkan arsitektur MVC melalui Laravel.
    </p>
    <div class="mt-6">
        <a class="text-link" href="{{ route('dashboard.mahasiswa.show', $profil['nrp']) }}">
            <span>Lihat rute profil melalui dashboard</span>
            <span aria-hidden="true">→</span>
        </a>
    </div>
</section>
@endsection

