@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<x-status-banner class="mb-6">{{ $user ? "Selamat datang, {$user}!" : 'Selamat datang di Portal Akademik PBKK.' }}</x-status-banner>
<section class="hero-panel border-t-4 border-t-[#f8ac18] p-6 sm:p-8 lg:p-10">
    <div class="grid gap-8 lg:grid-cols-[1.5fr_1fr] lg:items-center">
        <div>
            <span class="inline-flex items-center gap-2 rounded-md border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-blue-100">
                Portal PBKK · Teknik Informatika ITS
            </span>
            <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight text-white md:text-4xl lg:text-5xl">
                Portal Akademik &amp;<br>Laboratorium PBKK
            </h1>
            <p class="mt-4 max-w-xl text-base leading-relaxed text-blue-100/90">
                Ruang akademik {{ $profil['departemen'] }} ITS yang menghadirkan profil mahasiswa, alat hitung, masukan pengguna, serta <strong>ResearchMate AI</strong> untuk merencanakan riset.
            </p>
            <div class="mt-7 flex flex-wrap gap-3">
                <a class="button-gold" href="{{ route('idea') }}#demo-saran">
                    <span>Coba ResearchMate AI</span><span aria-hidden="true">→</span>
                </a>
                <a class="inline-flex items-center justify-center rounded-md border border-white/30 bg-white/10 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/20" href="{{ route('profile') }}">
                    Lihat profil mahasiswa
                </a>
            </div>
        </div>

        <div class="rounded-xl border border-white/15 bg-white/10 p-5 backdrop-blur-xs">
            <div class="flex items-center justify-between border-b border-white/15 pb-3">
                <p class="text-xs font-bold uppercase tracking-widest text-amber-300">Data Akademik Mahasiswa</p>
                <span class="rounded bg-white/20 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Aktif</span>
            </div>
            <dl class="mt-3.5 space-y-2 text-xs text-blue-50">
                <div class="flex justify-between gap-4 border-b border-white/10 py-1"><dt class="text-blue-200">Nama</dt><dd class="text-right font-semibold">{{ $profil['nama'] }}</dd></div>
                <div class="flex justify-between gap-4 border-b border-white/10 py-1"><dt class="text-blue-200">NRP</dt><dd class="font-mono font-bold text-amber-200">{{ $profil['nrp'] }}</dd></div>
                <div class="flex justify-between gap-4 border-b border-white/10 py-1"><dt class="text-blue-200">Departemen</dt><dd class="font-semibold">{{ $profil['departemen'] }}</dd></div>
                <div class="flex justify-between gap-4 py-1"><dt class="text-blue-200">Perguruan tinggi</dt><dd class="text-right font-semibold">{{ $profil['kampus'] }}</dd></div>
            </dl>
            <p class="mt-4 border-t border-white/15 pt-3 text-xs text-blue-200/90">Pemrograman Berbasis Kerangka Kerja · ITS</p>
        </div>
    </div>
</section>

<div class="mt-12 flex flex-wrap items-end justify-between gap-4">
    <div>
        <p class="eyebrow">Modul Aplikasi</p>
        <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Layanan &amp; Fitur Portal</h2>
    </div>
    <a class="text-link" href="{{ route('about') }}">Tentang portal →</a>
</div>

<div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
    <article class="feature-card border-t-3 border-t-[#2563eb] dark:border-t-sky-500">
        <p class="eyebrow">01 / Proyek AI</p>
        <h3 class="mt-3 text-lg font-bold text-slate-900 dark:text-white">ResearchMate AI</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Catat pertanyaan dan jumlah sumber untuk mendapat tinjauan awal yang dapat diperiksa.</p>
        <div class="mt-5 border-t border-slate-100 pt-3 dark:border-slate-800"><a class="text-link" href="{{ route('idea') }}#demo-saran">Tinjau rencana →</a></div>
    </article>

    <article class="feature-card border-t-3 border-t-[#f8ac18] dark:border-t-amber-400">
        <p class="eyebrow">02 / Akademik</p>
        <h3 class="mt-3 text-lg font-bold text-slate-900 dark:text-white">Profil &amp; Kalkulator</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Lihat identitas akademik dan gunakan kalkulator serta perhitungan IPK yang tersedia.</p>
        <div class="mt-5 border-t border-slate-100 pt-3 dark:border-slate-800"><a class="text-link" href="{{ route('calculator') }}#ipk">Hitung IPK →</a></div>
    </article>

    <article class="feature-card border-t-3 border-t-[#0f172a] dark:border-t-slate-400">
        <p class="eyebrow">03 / Masukan</p>
        <h3 class="mt-3 text-lg font-bold text-slate-900 dark:text-white">Masukan Pengguna</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Kirim evaluasi melalui formulir dengan validasi dan verifikasi sesi.</p>
        <div class="mt-5 border-t border-slate-100 pt-3 dark:border-slate-800"><a class="text-link" href="{{ route('feedback.create') }}">Tulis masukan →</a></div>
    </article>

    <article class="feature-card border-t-3 border-t-[#1d4ed8] dark:border-t-blue-500">
        <p class="eyebrow">04 / Akun Riset</p>
        <h3 class="mt-3 text-lg font-bold text-slate-900 dark:text-white">Proyek Saya</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Masuk untuk menyimpan rencana riset dan melihat proyek milik akun Anda.</p>
        <div class="mt-5 border-t border-slate-100 pt-3 dark:border-slate-800"><a class="text-link" href="{{ route('dashboard.home') }}">Buka ruang kerja →</a></div>
    </article>
</div>

<section class="mt-10 rounded-xl border border-blue-200/90 bg-blue-50/60 p-6 dark:border-blue-900/60 dark:bg-blue-950/40">
    <p class="eyebrow">Proyek ResearchMate AI</p>
    <h2 class="mt-1.5 text-xl font-bold text-slate-900 dark:text-white">Dari Pertanyaan Riset ke Proyek Saya</h2>
    <p class="mt-2 max-w-3xl text-sm leading-relaxed text-slate-600 dark:text-slate-300">
        Tulis pertanyaan dan jumlah sumber, tinjau saran awal, lalu masuk untuk menyimpan rencana sebagai proyek pribadi. Periksa artikel atau dokumen aslinya sebelum menarik kesimpulan.
    </p>
    <div class="mt-4"><a class="text-link" href="{{ route('idea') }}#demo-saran">Mulai rencana riset →</a></div>
</section>
@endsection
