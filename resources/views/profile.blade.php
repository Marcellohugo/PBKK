@extends('layouts.app')
@section('title', 'Detail Profil Mahasiswa')
@section('content')
<p class="eyebrow muted">Profil akademik</p><h1>{{ $profil['nama'] }}</h1>
<article class="card p-4 my-4"><dl class="row mb-0"><dt class="col-sm-3">NRP</dt><dd class="col-sm-9">{{ $profil['nrp'] }}</dd><dt class="col-sm-3">Departemen</dt><dd class="col-sm-9">{{ $profil['departemen'] }}</dd><dt class="col-sm-3">Perguruan tinggi</dt><dd class="col-sm-9">{{ $profil['kampus'] }}</dd></dl></article>
<h2 class="h4">Riwayat studi PBKK</h2><p class="muted">Kemajuan tugas pertemuan 1–2. Data mata kuliah lain dan nilai resmi belum tersedia.</p><ol>@foreach($riwayat as $item)<li>{{ $item }}</li>@endforeach</ol>
@endsection
