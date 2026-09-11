@extends('layouts.app')
@section('title', 'Ide Platform Agentic AI')
@section('content')
<p class="eyebrow muted">W2 · {{ $profil['ai']['fase'] }}</p><h1>{{ $tema }}</h1>
<article class="card p-4 my-4"><h2 class="h4">{{ $profil['tema'] }}</h2><p class="lead">{{ $profil['deskripsi'] }}</p><p class="mb-0">{{ $deskripsi }}</p></article>
<form method="GET" class="card p-4 mb-4">
    @error('mode')<p class="text-danger" role="alert">{{ $message }}</p>@enderror
    <label for="mode" class="form-label">Mode permainan</label>
    <select id="mode" name="mode" class="form-select">@foreach(['pemula' => 'Pemula', 'mahir' => 'Mahir'] as $value => $label)<option value="{{ $value }}" @selected($mode === $value)>{{ $label }}</option>@endforeach</select>
    <button class="btn btn-primary mt-3 align-self-start">Lihat skenario</button>
</form>
<h2 class="h4">Skenario saran · {{ ucfirst($mode) }}</h2>
<p class="muted">Data simulasi untuk memetakan masukan dan keluaran AI. Pinjaman hanya dibahas pada mode Mahir.</p>
<div class="row g-3">@foreach($skenario as $item)<div class="col-md-6"><article class="card p-4 h-100"><h3 class="h5">{{ $item['judul'] }}</h3><p>{{ $item['bukti'] }}</p><p class="mb-0"><strong>Saran awal:</strong> {{ $item['saran'] }}</p></article></div>@endforeach</div>
<div class="alert alert-info mt-4" role="status"><strong>Capaian W2:</strong> {{ $profil['ai']['capaian'] }} Setelah konsep W1, kini konteks mode dapat dipilih lewat routing. Berikutnya: evaluasi saran pada W3.</div>
<p class="muted">Saran masih berupa contoh tetap; LLM belum terhubung. Dasar rancangan: <a href="{{ $profil['ai']['sumber'] }}" target="_blank" rel="noopener">bagian Saran Analitika Pemain Narafin</a>.</p>
<a href="{{ route('agent') }}">Tampilkan tema default</a>
@endsection
