@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<x-status-banner class="mb-6">{{ $user ? "Selamat datang, {$user}!" : 'Selamat datang di Narafin AI Coach.' }}</x-status-banner>

<section class="hero-panel border-t-4 border-t-[#f8ac18] p-6 sm:p-8 lg:p-10">
    <div class="grid gap-8 lg:grid-cols-[1.5fr_1fr] lg:items-center">
        <div>
            <span class="inline-flex rounded-md border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-300">Analitika keputusan Cashflowpoly</span>
            <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight text-white md:text-4xl lg:text-5xl">Pahami permainan.<br>Ambil keputusan dengan bukti.</h1>
            <p class="mt-4 max-w-xl text-base leading-relaxed text-blue-100/90">Narafin AI Coach membantu instruktur meninjau perubahan kas, pemakaian bahan, dan pinjaman pemain. Setiap saran disertai angka yang dapat diperiksa.</p>
            <div class="mt-7 flex flex-wrap gap-3">
                <a class="button-gold" href="{{ route('idea') }}#demo-saran">Coba analitika <span aria-hidden="true">→</span></a>
                <a class="inline-flex items-center justify-center rounded-md border border-white/30 bg-white/10 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/20" href="{{ route('idea') }}#alur">Lihat cara kerja</a>
            </div>
        </div>
        <div class="rounded-xl border border-white/15 bg-white/10 p-5 backdrop-blur-xs">
            <div class="flex items-center justify-between border-b border-white/15 pb-3"><p class="text-xs font-bold uppercase tracking-widest text-amber-300">Ringkasan analisis</p><span class="rounded bg-white/20 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">3 indikator</span></div>
            <dl class="mt-3.5 space-y-3 text-sm text-blue-50">
                <div class="flex justify-between gap-4 border-b border-white/10 py-1"><dt class="text-blue-200">Kas</dt><dd class="font-semibold">Perubahan koin</dd></div>
                <div class="flex justify-between gap-4 border-b border-white/10 py-1"><dt class="text-blue-200">Bahan</dt><dd class="font-semibold">Persentase pemakaian</dd></div>
                <div class="flex justify-between gap-4 py-1"><dt class="text-blue-200">Pinjaman</dt><dd class="font-semibold">Sisa kewajiban</dd></div>
            </dl>
            <p class="mt-4 border-t border-white/15 pt-3 text-xs text-blue-200/90">Saran berbasis aturan dan data yang Anda masukkan.</p>
        </div>
    </div>
</section>

<div class="mt-12 flex flex-wrap items-end justify-between gap-4">
    <div><p class="eyebrow">Yang dapat Anda lakukan</p><h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Satu tempat untuk meninjau sesi</h2></div>
    <a class="text-link" href="{{ route('about') }}">Tentang Narafin AI Coach →</a>
</div>
<div class="mt-6 grid gap-5 md:grid-cols-3">
    <article class="feature-card border-t-3 border-t-[#013880] dark:border-t-sky-500"><p class="eyebrow">01 / Analitika</p><h3 class="mt-3 text-lg font-bold">Telusuri metrik pemain</h3><p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Bandingkan kondisi awal dan akhir untuk menemukan keputusan yang perlu ditinjau.</p><div class="mt-5 border-t border-slate-100 pt-3 dark:border-slate-800"><a class="text-link" href="{{ route('idea') }}#demo-saran">Buka analitika →</a></div></article>
    <article class="feature-card border-t-3 border-t-[#f8ac18] dark:border-t-amber-400"><p class="eyebrow">02 / Skenario</p><h3 class="mt-3 text-lg font-bold">Sesuaikan mode permainan</h3><p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Mode Pemula berfokus pada kas dan bahan; mode Mahir juga mempertimbangkan pinjaman.</p><div class="mt-5 border-t border-slate-100 pt-3 dark:border-slate-800"><a class="text-link" href="{{ route('idea', ['permainan' => 'mahir']) }}#demo-saran">Lihat mode Mahir →</a></div></article>
    <article class="feature-card border-t-3 border-t-[#001e3d] dark:border-t-sky-400"><p class="eyebrow">03 / Masukan</p><h3 class="mt-3 text-lg font-bold">Bantu tingkatkan saran</h3><p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Bagikan pengalaman dan beri masukan terkait indikator yang dipakai.</p><div class="mt-5 border-t border-slate-100 pt-3 dark:border-slate-800"><a class="text-link" href="{{ route('feedback.create') }}">Tulis masukan →</a></div></article>
</div>

<section class="mt-10 rounded-xl border border-blue-200/90 bg-blue-50/60 p-6 dark:border-blue-900/60 dark:bg-blue-950/40">
    <p class="eyebrow">Untuk instruktur</p><h2 class="mt-1.5 text-xl font-bold">Diskusi strategi dimulai dari data yang jelas</h2>
    <p class="mt-2 max-w-3xl text-sm leading-relaxed text-slate-600 dark:text-slate-300">Masukkan metrik sesi, periksa bukti perhitungan, lalu gunakan hasilnya sebagai bahan diskusi bersama pemain. Hasil bersifat bantuan analisis, bukan penilaian otomatis.</p>
    <a class="text-link mt-4 inline-flex" href="{{ route('idea') }}#alur">Pelajari alur analisis →</a>
</section>
@endsection
