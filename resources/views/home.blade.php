@extends('layouts.app')
@section('title', 'Laravel Local Sandbox')
@section('content')
<section class="hero mb-4"><p class="eyebrow">Pertemuan 02 · Routing sandbox</p><h1 class="display-5 fw-bold">Halo, {{ $profil['nama'] }}.</h1><p class="lead">Selamat datang di ruang akademik ITS.</p><a class="btn btn-light" href="{{ route('mahasiswa.show', ['nrp' => $profil['nrp']]) }}">Buka profil {{ $profil['nrp'] }}</a></section>
<div class="row g-4"><div class="col-md-7"><article class="card p-4 h-100"><h2 class="h4">Rancangan Agentic AI</h2><p>{{ $profil['tema'] }}</p><a href="{{ route('agent', ['tema' => $profil['tema']]) }}">Jelajahi ide proyek</a></article></div><div class="col-md-5"><article class="card p-4 h-100"><h2 class="h4">Profil akademik</h2><details><summary>Lihat identitas</summary><p class="mt-3">{{ $profil['nama'] }}<br>NRP {{ $profil['nrp'] }}<br>{{ $profil['departemen'] }}</p></details><a class="mt-3" href="{{ route('dashboard.mahasiswa.show', ['nrp' => $profil['nrp']]) }}">Profil melalui dashboard</a></article></div></div>
@endsection
