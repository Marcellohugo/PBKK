@extends('layouts.app')
@section('title', 'Konsep produk')
@section('content')
<div class="max-w-4xl">
    <span class="badge-its">Arah ResearchMate</span>
    <h1 class="mt-4 text-4xl font-extrabold tracking-tight">{{ $profil['tema'] }}</h1>
    <p class="mt-4 text-slate-600 dark:text-slate-300">Subtema Agentic AI menjadi arah ResearchMate: asisten yang membantu merencanakan pertanyaan, menelusuri bukti, dan meninjau hasil riset. {{ $profil['deskripsi'] }}</p>
    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Saat ini tinjauan rencana sudah tersedia. Tahapan berikut menggambarkan arah pengembangan platform.</p>
    <div class="mt-8 grid gap-4 md:grid-cols-3">
        <x-info-card title="Pertanyaan" label="Awal">Tentukan topik, tujuan, dan pertanyaan penelitian.</x-info-card>
        <x-info-card title="Literatur" label="Bukti">Kelola artikel dan PDF, lalu bandingkan metode serta temuan.</x-info-card>
        <x-info-card title="Laporan" label="Hasil">Susun ringkasan dan kandidat celah riset dengan sumber yang dapat diverifikasi.</x-info-card>
    </div>
    <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">Pengelolaan PDF, pencarian literatur, dan agen AI penuh merupakan arah platform ResearchMate; alur yang tersedia di aplikasi ini adalah tinjauan rencana awal.</p>
    <a class="button mt-6" href="{{ route('idea') }}">Tinjau rencana riset</a>
</div>
@endsection
