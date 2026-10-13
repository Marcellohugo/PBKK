@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<x-status-banner class="mb-6">{{ $user ? "Selamat datang, {$user}!" : 'Selamat datang di ResearchMate AI.' }}</x-status-banner>
<section class="hero-panel p-7 sm:p-10">
    <div class="grid items-center gap-8 lg:grid-cols-[1.5fr_1fr]">
        <div>
            <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-wide text-blue-100">Ruang kerja penelitian</span>
            <h1 class="mt-5 text-4xl font-extrabold leading-tight text-white md:text-5xl">Riset yang tertata, bukti yang mudah ditelusuri.</h1>
            <p class="mt-4 max-w-2xl text-blue-100">Mulai dari pertanyaan riset. Susun proyek, catat sumber literatur, dan tinjau langkah berikutnya sebelum membuat kesimpulan.</p>
            <div class="mt-7 flex flex-wrap gap-3"><a class="button" href="{{ route('idea') }}">Mulai rencana riset</a><a class="button-secondary" href="{{ route('dashboard.home') }}">Lihat proyek saya</a></div>
        </div>
        <div class="rounded-xl border border-white/20 bg-white/10 p-6 text-white">
            <p class="text-xs font-bold uppercase tracking-wider text-blue-200">Alur ResearchMate</p>
            <ol class="mt-5 space-y-4 text-sm">
                <li><span class="mr-3 font-bold text-blue-200">01</span> Rumuskan pertanyaan dan tujuan.</li>
                <li><span class="mr-3 font-bold text-blue-200">02</span> Kumpulkan artikel dan dokumen.</li>
                <li><span class="mr-3 font-bold text-blue-200">03</span> Bandingkan temuan dan periksa bukti.</li>
                <li><span class="mr-3 font-bold text-blue-200">04</span> Susun laporan yang dapat ditelusuri.</li>
            </ol>
        </div>
    </div>
</section>
<section class="mt-10 grid gap-4 md:grid-cols-3">
    <x-info-card title="Proyek pribadi" label="Ruang kerja">Lihat daftar proyek riset yang terhubung dengan akun Anda.</x-info-card>
    <x-info-card title="Kesiapan literatur" label="Rencana">Catat jumlah artikel dan PDF untuk mendapat langkah tinjauan awal.</x-info-card>
    <x-info-card title="Masukan terverifikasi" label="Kolaborasi">Kirim tanggapan melalui formulir dengan validasi dan verifikasi sesi.</x-info-card>
</section>
<p class="mt-10 text-xs text-slate-500 dark:text-slate-400">Dikembangkan oleh {{ config('profile.nama') }} · {{ config('profile.nrp') }} · Teknik Informatika ITS</p>
@endsection
