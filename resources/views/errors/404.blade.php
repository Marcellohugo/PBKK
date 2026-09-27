@extends('layouts.app')
@section('title', 'Halaman Tidak Ditemukan')
@section('content')
<div class="mx-auto max-w-xl text-center py-12">
    <div class="badge-gold mb-4">
        Galat 404 · Sistem Informasi ITS
    </div>
    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white md:text-4xl">Halaman tidak ditemukan</h1>
    <p class="mt-3 text-base text-slate-600 dark:text-slate-300">Periksa kembali alamat yang dimasukkan.</p>
    <div class="mt-6">
        <a class="button" href="{{ route('home') }}">Kembali ke beranda</a>
    </div>
</div>
@endsection

