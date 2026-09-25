@extends('layouts.app')
@section('title', 'Ide Proyek')
@section('content')
<p class="eyebrow">Usulan Agentic AI</p><h1 class="mt-3 text-4xl font-bold">{{ $profil['tema'] }}</h1><p class="mt-5 max-w-3xl text-lg">{{ $profil['deskripsi'] }}</p>
<div class="mt-8 grid gap-5 md:grid-cols-3"><x-info-card title="Masukan" label="Data">Instruktur memilih pemain, sesi, dan mode permainan.</x-info-card><x-info-card title="Analisis" label="Proses">Aplikasi menghitung kas, penggunaan bahan, dan pinjaman yang tersedia.</x-info-card><x-info-card title="Saran" label="Keluaran">Hasil berbasis bukti disajikan untuk ditinjau instruktur.</x-info-card></div>
<a class="mt-8 inline-block font-semibold text-sky-800 dark:text-sky-300" href="{{ route('idea') }}">Lihat rancangan dan demo →</a>
@endsection
