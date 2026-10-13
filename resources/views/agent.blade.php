@extends('layouts.app')
@section('title', 'Agen riset')
@section('content')
<div class="max-w-4xl">
    <span class="badge-its">Alur penelitian</span>
    <h1 class="mt-4 text-4xl font-extrabold tracking-tight">{{ $tema }}</h1>
    <p class="mt-4 text-slate-600 dark:text-slate-300">{{ $deskripsi }}</p>
    <div class="mt-6 flex flex-wrap gap-2"><a class="button-secondary" href="{{ route('agent', ['mode' => 'jelajah']) }}">Jelajah sumber</a><a class="button-secondary" href="{{ route('agent', ['mode' => 'telaah']) }}">Telaah bukti</a></div>
    <div class="mt-8 grid gap-4 sm:grid-cols-2">
        @foreach($skenario as $item)
            <article class="feature-card"><p class="eyebrow">{{ $item['judul'] }}</p><h2 class="mt-2 text-lg font-bold">{{ $item['bukti'] }}</h2><p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $item['saran'] }}</p></article>
        @endforeach
    </div>
    <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">Ini gambaran peran agen pada ResearchMate. Tinjauan rencana di aplikasi ini menggunakan aturan transparan, bukan panggilan model AI.</p>
    <a class="text-link mt-5" href="{{ route('idea') }}">Tinjau rencana riset →</a>
</div>
@endsection
