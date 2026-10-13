@extends('layouts.app')
@section('title', 'Profil Mahasiswa')
@section('content')
<div class="max-w-4xl">
    <span class="badge-its">Profil Mahasiswa · Teknik Informatika ITS</span>
    <h1 class="mt-4 text-4xl font-extrabold tracking-tight">{{ $profil['nama'] }}</h1>
    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $profil['departemen'] }} · {{ $profil['kampus'] }} · NRP {{ $profil['nrp'] }}</p>
    <div class="mt-8 grid gap-4 md:grid-cols-2">
        <x-info-card title="Identitas akademik" label="Mahasiswa"><dl class="space-y-2"><div class="flex justify-between gap-4"><dt>NRP</dt><dd class="font-mono font-bold">{{ $profil['nrp'] }}</dd></div><div class="flex justify-between gap-4"><dt>Departemen</dt><dd class="font-semibold">{{ $profil['departemen'] }}</dd></div><div class="flex justify-between gap-4"><dt>Perguruan tinggi</dt><dd class="text-right font-semibold">{{ $profil['kampus'] }}</dd></div></dl></x-info-card>
        <x-info-card :title="$profil['tema']" label="Proyek AI">{{ $profil['deskripsi'] }}<a class="text-link mt-4" href="{{ route('idea') }}">Lihat rencana riset →</a></x-info-card>
    </div>
    <section class="mt-8 feature-card"><p class="eyebrow">ResearchMate AI</p><h2 class="mt-2 text-xl font-bold">Layanan untuk rencana riset</h2><ul class="mt-4 list-inside list-disc space-y-2 text-sm text-slate-600 dark:text-slate-300">@foreach($layanan as $item)<li>{{ $item }}</li>@endforeach</ul></section>
</div>
@endsection
