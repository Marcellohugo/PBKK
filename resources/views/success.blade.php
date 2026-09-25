@extends('layouts.app')
@section('title', 'Masukan Berhasil')
@section('content')
<p class="rounded-xl bg-green-100 p-4 text-green-900" role="status">Terima kasih, {{ $feedback['nama'] }}. Masukan berhasil divalidasi.</p>
<article class="mt-6 rounded-2xl bg-white p-6 shadow-sm dark:bg-slate-900"><p class="eyebrow">{{ $feedback['kategori'] }}</p><h1 class="mt-3 text-3xl font-bold">Konfirmasi masukan</h1><p class="mt-4">{{ $feedback['email'] }}</p><p class="mt-4 whitespace-pre-wrap">{{ $feedback['pesan'] }}</p></article>
@if(!empty($feedback['mode_permainan']) && !empty($feedback['indikator']))<p class="mt-5">Konteks Narafin: {{ ucfirst($feedback['mode_permainan']) }} · {{ config('profile.ai.indikator.'.$feedback['indikator']) }}</p>@endif
<p class="mt-5">Konfirmasi ini hanya tersedia dalam sesi browser. Masukan belum disimpan atau dikirim ke departemen.</p><a class="mt-6 inline-block font-semibold text-sky-800 dark:text-sky-300" href="{{ route('feedback.create') }}">Tulis masukan baru</a>
@endsection
