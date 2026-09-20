@extends('layouts.app')
@section('title', 'Halaman Tidak Ditemukan')
@section('content')
<section class="card p-5 text-center"><p class="eyebrow muted">404</p><h1>Halaman atau mahasiswa tidak ditemukan</h1><p>Periksa alamat tujuan dan pastikan NRP terdiri dari 10 digit serta terdaftar pada profil.</p><a href="{{ route('home') }}">Kembali ke beranda</a></section>
@endsection
