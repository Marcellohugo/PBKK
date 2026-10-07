@extends('layouts.app')
@section('title', 'Tentang')
@section('content')
<div class="max-w-4xl border-b border-slate-200/80 pb-6 dark:border-slate-800/80">
    <span class="badge-its">Tentang produk</span>
    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl">Narafin AI Coach</h1>
    <p class="mt-4 text-base leading-relaxed text-slate-600 dark:text-slate-300">Alat bantu bagi instruktur Cashflowpoly untuk mengubah metrik sesi menjadi saran yang jelas dan dapat diperiksa. Fokusnya adalah menjelaskan alasan di balik perubahan kas, penggunaan bahan, dan pinjaman.</p>
</div>

<div class="mt-8 grid gap-6 md:grid-cols-2">
    <div class="feature-card p-6"><p class="eyebrow">Cara kerja</p><h2 class="mt-2 text-xl font-bold">Dari angka ke keputusan</h2><p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Masukkan metrik permainan dan pilih mode. Sistem menghitung perubahan, memeriksa kondisi yang relevan, lalu menampilkan saran beserta bukti angkanya.</p></div>
    <div class="feature-card p-6"><p class="eyebrow">Batas hasil</p><h2 class="mt-2 text-xl font-bold">Instruktur tetap menentukan langkah</h2><p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-300">Saran saat ini berbasis aturan yang dapat ditelusuri. Hasil membantu diskusi dan perlu ditinjau bersama konteks sesi sebelum digunakan.</p></div>
</div>

<div class="mt-8 flex flex-wrap gap-4">
    <a class="button" href="{{ route('idea') }}#demo-saran">Coba analitika <span aria-hidden="true">→</span></a>
    <a class="button-secondary" href="{{ route('profile') }}">Tentang pengembang</a>
    <a class="button-secondary" href="{{ route('calculator') }}">Alat hitung tambahan</a>
</div>
@endsection
