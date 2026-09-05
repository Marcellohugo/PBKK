@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<section class="hero mb-4">
    <p class="eyebrow">ITS Academic Profile · Pertemuan 01</p>
    <h1 class="display-5 fw-bold">Selamat datang,<br>{{ $profil['nama'] }}.</h1>
    <p class="lead mt-3 mb-0">NRP {{ $profil['nrp'] }} · {{ $profil['departemen'] }}</p>
</section>
<div class="row g-4">
    <div class="col-md-7"><article class="card h-100 p-4"><h2 class="h4">Ruang belajar framework</h2><p>Profil akademik dan rancangan proyek akhir mata kuliah Pemrograman Berbasis Kerangka Kerja.</p><a href="{{ route('about') }}">Kenali departemen</a></article></div>
    <div class="col-md-5"><article class="card h-100 p-4"><p class="eyebrow muted">W1 · Konsep awal</p><h2 class="h4">{{ $profil['tema'] }}</h2><p>{{ $profil['ai']['capaian'] }}</p><a href="{{ route('project') }}">Lihat ide Agentic AI</a></article></div>
</div>
@endsection
