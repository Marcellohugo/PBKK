@extends('layouts.app')
@section('title', 'Agent AI')
@section('content')
<p class="eyebrow">Rancangan agent</p><h1 class="mt-3 text-4xl font-bold">{{ $tema }}</h1><p class="mt-4 max-w-3xl">{{ $deskripsi }}</p>
<div class="mt-6 flex gap-3">@foreach(['pemula' => 'Pemula', 'mahir' => 'Mahir'] as $value => $label)<a class="rounded-xl border border-slate-300 px-4 py-2 {{ $mode === $value ? 'font-bold text-sky-800' : '' }}" href="{{ route('agent', ['tema' => $tema, 'mode' => $value]) }}">{{ $label }}</a>@endforeach</div>
<div class="mt-8 grid gap-5 md:grid-cols-2">@foreach($skenario as $item)<x-info-card :title="$item['judul']" :label="$profil['ai']['indikator'][$item['indikator']]"><p>{{ $item['bukti'] }}</p><p class="mt-3 font-semibold">{{ $item['saran'] }}</p></x-info-card>@endforeach</div>
@endsection
