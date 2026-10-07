@extends('layouts.app')
@section('title', 'Agent AI')
@section('content')
<div class="max-w-4xl border-b border-slate-200/80 pb-6 dark:border-slate-800/80">
    <div class="badge-its">
        Skenario analitika
    </div>
    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl">{{ $tema }}</h1>
    <p class="mt-4 text-base leading-relaxed text-slate-600 dark:text-slate-300">{{ $deskripsi }}</p>
</div>

<div class="mt-8 flex flex-wrap items-center gap-3">
    <span class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Pilih mode:</span>
    <div class="inline-flex rounded-md border border-slate-300 bg-slate-100 p-1 dark:border-slate-700 dark:bg-slate-900" aria-label="Pilih mode">
        @foreach(['pemula' => 'Pemula', 'mahir' => 'Mahir'] as $value => $label)
        <a class="rounded px-4 py-1.5 text-xs font-bold transition-all duration-150 {{ $mode === $value ? 'bg-[#013880] text-white shadow-2xs dark:bg-sky-600' : 'text-slate-700 hover:text-[#013880] dark:text-slate-300 dark:hover:text-white' }}" 
           href="{{ route('agent', ['tema' => $tema, 'mode' => $value]) }}">
           {{ $label }}
        </a>
        @endforeach
    </div>
</div>
@error('mode')
    <p class="error mt-3" role="alert">{{ $message }}</p>
@enderror

<div class="mt-8">
    <div class="flex items-center justify-between border-b border-slate-200/80 pb-4 dark:border-slate-800/80">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Skenario saran · Mode {{ ucfirst($mode) }}</h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Contoh saran berdasarkan indikator permainan yang tersedia.</p>
        </div>
        <span class="badge-its">
            {{ count($skenario) }} skenario aktif
        </span>
    </div>

    <div class="mt-6 grid gap-6 md:grid-cols-2">
        @foreach($skenario as $item)
        <x-info-card :title="$item['judul']" :label="$profil['ai']['indikator'][$item['indikator']]" class="border-t-3 border-t-[#013880]">
            <div class="space-y-3">
                <p class="rounded-md bg-slate-50 p-3 text-xs font-mono text-slate-800 dark:bg-slate-800/60 dark:text-slate-200 border border-slate-200/80 dark:border-slate-700/80">
                    {{ $item['bukti'] }}
                </p>
                <div class="pt-1">
                    <p class="eyebrow">Rekomendasi tindakan:</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $item['saran'] }}</p>
                </div>
            </div>
        </x-info-card>
        @endforeach
    </div>
</div>
@endsection

