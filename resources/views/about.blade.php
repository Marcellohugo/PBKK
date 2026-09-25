@extends('layouts.app')
@section('title', 'Tentang')
@section('content')
<p class="eyebrow">Tentang aplikasi</p><h1 class="mt-3 text-4xl font-bold">Profil dan proyek PBKK</h1>
<p class="mt-5 max-w-3xl text-lg">Aplikasi ini menampilkan profil mahasiswa, rancangan Narafin AI Coach, kalkulator, dan formulir masukan dengan Laravel.</p>
<div class="mt-8 flex flex-wrap gap-4"><a class="rounded-xl bg-sky-900 px-5 py-3 font-semibold text-white" href="{{ route('profile') }}">Lihat profil</a><a class="rounded-xl border border-slate-300 px-5 py-3 font-semibold" href="{{ route('project') }}">Baca ide proyek</a></div>
@endsection
