@extends('layouts.app')
@section('title', 'Halaman Tidak Ditemukan')
@section('content')
<h1 class="text-4xl font-bold">Halaman tidak ditemukan</h1><p class="mt-4">Periksa kembali alamat yang dimasukkan.</p><a class="mt-6 inline-block font-semibold text-sky-800" href="{{ route('home') }}">Kembali ke beranda</a>
@endsection
