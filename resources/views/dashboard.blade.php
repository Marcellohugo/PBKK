@extends('layouts.app')
@section('title', 'Proyek saya')
@section('content')
@if(session('status'))<x-status-banner type="success" class="mb-6">{{ session('status') }}</x-status-banner>@endif
<section class="hero-panel p-7">
    <p class="text-xs font-bold uppercase tracking-wider text-amber-300">Ruang kerja pribadi</p>
    <h1 class="mt-3 text-3xl font-extrabold text-white">Proyek riset {{ auth()->user()->name }}</h1>
    <p class="mt-2 text-sm text-blue-100">{{ $projects->count() }} proyek tersimpan pada akun Anda.</p>
    <form method="POST" action="{{ route('research.new') }}" class="mt-6">@csrf<button class="button-gold" type="submit">Mulai rencana baru →</button></form>
</section>

@if(session()->has('research_plan'))
    <section class="mt-6 rounded-xl border border-amber-300 bg-amber-50 p-5 dark:border-amber-800 dark:bg-amber-950/30">
        <p class="eyebrow">Rencana belum disimpan</p>
        <h2 class="mt-2 text-lg font-bold">Lanjutkan rencana terakhir Anda</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Tinjauan sementara masih tersedia di sesi browser ini. Beri judul agar masuk ke daftar proyek.</p>
        <a class="text-link mt-3" href="{{ route('idea') }}#simpan-proyek">Lanjut simpan proyek →</a>
    </section>
@endif

<div class="mt-9 flex flex-wrap items-end justify-between gap-3">
    <div><p class="eyebrow">Proyek Anda</p><h2 class="mt-1 text-2xl font-bold">Daftar penelitian</h2></div>
    <span class="text-xs text-slate-500">Terbaru dahulu</span>
</div>
@forelse($projects as $project)
    <article class="feature-card mt-4">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div><span class="badge-its">{{ $project->tema_agent }}</span><h3 class="mt-3 text-xl font-bold">{{ $project->judul }}</h3></div>
            <time class="text-xs text-slate-500" datetime="{{ $project->created_at->toDateString() }}">{{ $project->created_at->translatedFormat('d F Y') }}</time>
        </div>
        <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">{{ $project->deskripsi ?: 'Belum ada ringkasan.' }}</p>
        @if($project->pertanyaan_riset)
            <div class="mt-4 border-t border-slate-200 pt-4 text-sm dark:border-slate-800">
                <p><span class="font-semibold">Pertanyaan:</span> {{ $project->pertanyaan_riset }}</p>
                <p class="mt-2 text-slate-600 dark:text-slate-300">{{ $project->jumlah_artikel }} artikel · {{ $project->jumlah_pdf }} PDF dicatat · {{ $project->mode_riset === 'dokumen_lokal' ? 'Dokumen lokal' : 'Penelusuran literatur' }}</p>
            </div>
        @endif
        <a class="text-link mt-4" href="{{ route('dashboard.project.show', $project) }}">Lihat detail proyek →</a>
    </article>
@empty
    <div class="feature-card mt-4">
        <h3 class="text-lg font-bold">Belum ada proyek</h3>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Mulai dari pertanyaan riset, tinjau sumber, lalu simpan rencana pertama Anda di sini.</p>
        <form method="POST" action="{{ route('research.new') }}" class="mt-4">@csrf<button class="text-link" type="submit">Buat rencana riset →</button></form>
    </div>
@endforelse
@endsection
