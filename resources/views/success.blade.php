@extends('layouts.app')
@section('title', 'Masukan Berhasil Diproses')
@section('content')
<div class="alert alert-success" role="status">Terima kasih, {{ $feedback['nama'] }}. Masukan berhasil divalidasi!</div>
<article class="card p-4 my-4"><p class="eyebrow muted">{{ $feedback['kategori'] }}</p><h1 class="h3">Konfirmasi masukan</h1><p>{{ $feedback['email'] }}</p><p class="mb-0" style="white-space:pre-wrap">{{ $feedback['pesan'] }}</p></article>
@if(!empty($feedback['mode_permainan']) && !empty($feedback['indikator']))
<p><strong>Konteks evaluasi Narafin:</strong> {{ ucfirst($feedback['mode_permainan']) }} · {{ config('profile.ai.indikator.'.$feedback['indikator']) }}</p>
@endif
<p class="muted">Konfirmasi ini sementara di sesi browser. Masukan belum disimpan ke database atau dikirim ke departemen maupun Narafin.</p><a class="btn btn-primary" href="{{ route('feedback.create') }}">Tulis masukan baru</a>
@endsection
