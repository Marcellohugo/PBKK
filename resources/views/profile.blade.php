@extends('layouts.app')
@section('title', 'Tim')
@section('content')
<div class="max-w-4xl">
    <span class="badge-its">Tim ResearchMate</span>
    <h1 class="mt-4 text-4xl font-extrabold tracking-tight">{{ $profil['nama'] }}</h1>
    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $profil['departemen'] }} · {{ $profil['kampus'] }} · NRP {{ $profil['nrp'] }}</p>
    <div class="mt-8 grid gap-4 md:grid-cols-2">
        <x-info-card title="Fokus pengembangan" label="Produk">{{ $profil['deskripsi'] }}</x-info-card>
        <x-info-card title="Kemajuan" label="Ruang kerja"><ul class="space-y-2">@foreach($riwayat as $item)<li>{{ $item }}</li>@endforeach</ul></x-info-card>
    </div>
    <section class="mt-8 feature-card"><h2 class="text-xl font-bold">Departemen Teknik Informatika ITS</h2><p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Departemen ini berada di Institut Teknologi Sepuluh Nopember, Surabaya. Pengembangan ResearchMate berfokus pada alur kerja penelitian akademik yang rapi dan dapat ditinjau.</p></section>
</div>
@endsection
