@extends('layouts.app')
@section('title', 'Pengembang')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200/80 pb-6 dark:border-slate-800/80">
    <div class="flex items-center gap-4">
        <div class="grid h-16 w-16 place-items-center rounded-lg bg-[#013880] text-2xl font-black text-white shadow-xs border-2 border-[#f8ac18]">
            MH
        </div>
        <div>
            <p class="eyebrow">Tim produk</p>
            <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl">{{ $profil['nama'] }}</h1>
            <p class="mt-0.5 text-sm font-semibold text-slate-500 dark:text-slate-400">NRP {{ $profil['nrp'] }} · {{ $profil['departemen'] }}</p>
        </div>
    </div>
    <span class="badge-its">
        Pengembang Narafin AI Coach
    </span>
</div>

<div class="mt-8 grid gap-6 md:grid-cols-2">
    <x-info-card title="Tentang pengembang" label="Latar belakang">
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

    <x-info-card :title="$profil['tema']" label="Produk yang dikembangkan">
        <p class="leading-relaxed">{{ $profil['deskripsi'] }}</p>
        <div class="mt-5 pt-3 border-t border-slate-100 dark:border-slate-800">
            <a class="text-link" href="{{ route('idea') }}">
                <span>Lihat analitika dan contoh sesi</span>
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </x-info-card>
</div>

<x-info-card class="mt-6 border-t-3 border-t-[#013880]" title="Riwayat belajar dan pengembangan" label="Pengembangan produk">
    <p class="mb-4 text-xs font-semibold text-slate-500 dark:text-slate-400">Pengalaman yang diterapkan dalam pengembangan Narafin AI Coach.</p>
    <ul class="space-y-2.5 text-sm">
        @foreach($riwayat as $item)
        <li class="flex items-start gap-3">
            <span class="mt-0.5 grid h-4 w-4 shrink-0 place-items-center rounded-full bg-blue-100 text-[10px] font-bold text-[#013880] dark:bg-blue-950 dark:text-sky-300">✓</span>
            <span class="text-slate-700 dark:text-slate-300 leading-relaxed">{{ $item }}</span>
        </li>
        @endforeach
    </ul>
</x-info-card>

<section id="tentang" class="mt-12 scroll-mt-10 rounded-xl border border-slate-200/90 bg-white p-7 shadow-xs dark:border-slate-800 dark:bg-[#0b1c33]">
    <p class="eyebrow">Latar belakang</p>
    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Teknik Informatika ITS</h2>
    <p class="mt-4 max-w-3xl leading-relaxed text-slate-600 dark:text-slate-300">
        Pengembang berasal dari Departemen Teknik Informatika, Institut Teknologi Sepuluh Nopember, Surabaya. Fokus pengembangannya mencakup aplikasi web, basis data, dan analitika yang mudah dipahami pengguna.
    </p>
    <div class="mt-6"><a class="text-link" href="{{ route('idea') }}#demo-saran">Jelajahi analitika →</a></div>
</section>
@endsection

