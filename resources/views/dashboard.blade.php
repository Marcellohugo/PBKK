@extends('layouts.app')
@section('title', 'Proyek saya')
@section('content')
<section class="hero-panel p-7"><p class="text-xs font-bold uppercase tracking-wider text-blue-200">Ruang kerja pribadi</p><h1 class="mt-3 text-3xl font-extrabold text-white">Selamat datang, {{ auth()->user()->name }}</h1><p class="mt-2 text-sm text-blue-100">{{ $projects->count() }} proyek riset terhubung dengan akun Anda</p></section>
<div class="mt-9 flex items-end justify-between gap-3"><div><p class="eyebrow">Proyek Anda</p><h2 class="mt-1 text-2xl font-bold">Daftar penelitian</h2></div><span class="text-xs text-slate-500">Terbaru dahulu</span></div>
@forelse($projects as $project)
<article class="feature-card mt-4"><div class="flex flex-wrap items-start justify-between gap-3"><div><span class="badge-its">{{ $project->tema_agent }}</span><h3 class="mt-3 text-xl font-bold">{{ $project->judul }}</h3></div><time class="text-xs text-slate-500" datetime="{{ $project->created_at->toDateString() }}">{{ $project->created_at->translatedFormat('d F Y') }}</time></div><p class="mt-3 text-sm text-slate-600 dark:text-slate-300">{{ $project->deskripsi ?: 'Belum ada deskripsi.' }}</p></article>
@empty
<div class="feature-card mt-4"><h3 class="text-lg font-bold">Belum ada proyek</h3><p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Proyek yang terhubung dengan akun Anda akan muncul di sini.</p><a class="text-link mt-4" href="{{ route('idea') }}">Tinjau rencana riset →</a></div>
@endforelse
@endsection
