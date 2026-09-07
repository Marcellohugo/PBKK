@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<section class="hero mb-5">
    <p class="eyebrow mb-4">Ruang akademik · Teknik Informatika ITS</p>
    <h1 class="display-4 fw-bold">Belajar, merancang, membangun.</h1>
    <p class="lead mt-4">Halo, saya {{ $profil['nama'] }}. Di sini saya mendokumentasikan proses belajar framework dan rancangan proyek Agentic AI.</p>
    <div class="d-flex flex-wrap gap-3 mt-4"><a class="btn btn-light" href="{{ route('project') }}">Jelajahi ide proyek</a><a class="btn btn-outline-light" href="{{ route('about') }}">Kenali profil akademik</a></div>
    <p class="small mt-4 mb-0 text-white-50">NRP {{ $profil['nrp'] }} · {{ $profil['departemen'] }}</p>
</section>
<p class="eyebrow muted mb-2">Mulai dari sini</p><h2 class="h3 fw-bold mb-4">Dua hal yang sedang saya kerjakan</h2>
<div class="row g-4">
    <div class="col-md-6"><article class="card h-100 p-4 p-lg-5"><p class="eyebrow muted">01 / Akademik</p><h3 class="h4 fw-bold">Ruang belajar framework</h3><p class="muted">Profil akademik dan penerapan MVC dalam Pemrograman Berbasis Kerangka Kerja.</p><a class="feature-link mt-auto" href="{{ route('about') }}">Kenali departemen</a></article></div>
    <div class="col-md-6"><article class="card h-100 p-4 p-lg-5"><p class="eyebrow muted">02 / Rancangan</p><h3 class="h4 fw-bold">{{ $profil['tema'] }}</h3><p class="muted">{{ $profil['ai']['capaian'] }}</p><a class="feature-link mt-auto" href="{{ route('project') }}">Lihat ide Agentic AI</a></article></div>
</div>
@endsection
