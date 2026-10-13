@extends('layouts.app')
@section('title', $project->judul)
@section('content')
<a class="text-link" href="{{ route('dashboard.home') }}">← Kembali ke Proyek Saya</a>
<section class="hero-panel mt-6 p-7">
    <span class="text-xs font-bold uppercase tracking-wider text-amber-300">Proyek riset tersimpan</span>
    <h1 class="mt-3 text-3xl font-extrabold text-white">{{ $project->judul }}</h1>
    <p class="mt-2 text-sm text-blue-100">Dibuat {{ $project->created_at->translatedFormat('d F Y') }} · {{ $project->tema_agent }}</p>
</section>

<div class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_1fr] lg:items-start">
    <section class="feature-card">
        <p class="eyebrow">Rencana tersimpan</p>
        <h2 class="mt-2 text-xl font-bold">Arah penelitian</h2>
        <p class="mt-4 text-sm text-slate-600 dark:text-slate-300">{{ $project->deskripsi ?: 'Belum ada ringkasan proyek.' }}</p>
        @if($project->pertanyaan_riset)
            <dl class="mt-5 space-y-4 border-t border-slate-200 pt-5 text-sm dark:border-slate-800">
                <div><dt class="font-semibold">Pertanyaan riset</dt><dd class="mt-1 text-slate-600 dark:text-slate-300">{{ $project->pertanyaan_riset }}</dd></div>
                <div><dt class="font-semibold">Sumber utama</dt><dd class="mt-1 text-slate-600 dark:text-slate-300">{{ $project->mode_riset === 'dokumen_lokal' ? 'Dokumen lokal' : 'Penelusuran literatur' }}</dd></div>
                <div><dt class="font-semibold">Inventaris sumber</dt><dd class="mt-1 text-slate-600 dark:text-slate-300">{{ $project->jumlah_artikel }} artikel · {{ $project->jumlah_pdf }} PDF dicatat</dd></div>
            </dl>
        @else
            <p class="mt-5 border-t border-slate-200 pt-5 text-sm text-slate-600 dark:border-slate-800 dark:text-slate-300">Proyek contoh ini belum memiliki rencana riset terperinci.</p>
        @endif
    </section>

    <section class="feature-card">
        <p class="eyebrow">Langkah berikutnya</p>
        @if($project->pertanyaan_riset)
            <h2 class="mt-2 text-xl font-bold">Tinjau sumber asli</h2>
            <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">{{ $project->mode_riset === 'dokumen_lokal' ? 'Periksa PDF yang relevan dan catat asal, tahun, metode, serta hasilnya.' : 'Telusuri artikel yang relevan dan catat asal, tahun, metode, serta hasilnya.' }} Cocokkan temuan dengan pertanyaan riset sebelum membuat kesimpulan.</p>
            <p class="mt-4 text-xs text-slate-500 dark:text-slate-400">Jumlah sumber di atas berasal dari catatan Anda; aplikasi belum memeriksa isi dokumen.</p>
        @else
            <h2 class="mt-2 text-xl font-bold">Susun rencana riset</h2>
            <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">Proyek ini belum memiliki pertanyaan dan inventaris sumber. Buat rencana baru untuk mencatat keduanya sebagai proyek baru.</p>
            <form method="POST" action="{{ route('research.new') }}" class="mt-4">@csrf<button class="text-link" type="submit">Mulai rencana baru →</button></form>
        @endif
    </section>
</div>
@endsection
