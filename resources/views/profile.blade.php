@extends('layouts.app')
@section('title', 'Profil Mahasiswa')
@section('content')
<p class="eyebrow">Kenali mahasiswa</p><h1 class="mt-3 text-4xl font-bold">{{ $profil['nama'] }}</h1>
<div class="mt-8 grid gap-6 md:grid-cols-2"><x-info-card title="Identitas akademik" label="Profil"><dl class="space-y-3"><div><dt class="font-semibold">NRP</dt><dd>{{ $profil['nrp'] }}</dd></div><div><dt class="font-semibold">Departemen</dt><dd>{{ $profil['departemen'] }}</dd></div><div><dt class="font-semibold">Perguruan tinggi</dt><dd>{{ $profil['kampus'] }}</dd></div></dl></x-info-card><x-info-card :title="$profil['tema']" label="Usulan proyek"><p>{{ $profil['deskripsi'] }}</p><a class="mt-5 inline-block font-semibold text-sky-800" href="{{ route('idea') }}">Lihat alur rancangan</a></x-info-card></div>
@isset($riwayat)<x-info-card class="mt-6" title="Riwayat belajar" label="PBKK"><ul class="list-disc space-y-2 pl-5">@foreach($riwayat as $item)<li>{{ $item }}</li>@endforeach</ul></x-info-card>@endisset
<p class="mt-6"><a class="font-semibold text-sky-800 dark:text-sky-300" href="{{ route('mahasiswa.show', $profil['nrp']) }}">Lihat riwayat belajar →</a></p>
@endsection
