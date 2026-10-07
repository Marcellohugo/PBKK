@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<section class="hero-panel border-t-4 border-t-[#f8ac18] p-6 sm:p-8">
    <p class="text-xs font-bold uppercase tracking-widest text-amber-300">Portofolio pribadi</p>
    <h1 class="mt-3 text-3xl font-extrabold text-white">Selamat datang, {{ auth()->user()->name }}</h1>
    <p class="mt-2 text-sm text-blue-100">{{ auth()->user()->email }} · {{ $projects->count() }} proyek tersimpan</p>
</section>

<div class="mt-10 flex flex-wrap items-end justify-between gap-3">
    <div><p class="eyebrow">Database proyek</p><h2 class="mt-1 text-2xl font-bold">Proyek Agentic AI saya</h2></div>
    <span class="badge-its">Terbaru dahulu</span>
</div>

@forelse ($projects as $project)
    <article class="feature-card mt-5 border-l-4 border-l-[#013880] p-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div><span class="badge-gold">{{ $project->tema_agent }}</span><h3 class="mt-3 text-xl font-bold">{{ $project->judul }}</h3></div>
            <time class="text-xs text-slate-500 dark:text-slate-400" datetime="{{ $project->created_at->toDateString() }}">{{ $project->created_at->translatedFormat('d F Y') }}</time>
        </div>
        <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-300">{{ $project->deskripsi ?: 'Belum ada deskripsi.' }}</p>
    </article>
@empty
    <div class="feature-card mt-5 p-8 text-center"><h3 class="text-lg font-bold">Belum ada proyek</h3><p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Proyek portofolio Anda akan muncul di sini setelah ditambahkan.</p></div>
@endforelse
@endsection
