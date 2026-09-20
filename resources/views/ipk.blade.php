@extends('layouts.app')
@section('title', 'Kalkulator IPK')
@section('content')
<p class="eyebrow muted">Challenge · Parameter dinamis</p><h1>Kalkulator IPK dua semester</h1><p class="muted">Rata-rata sederhana sesuai tugas, dengan asumsi bobot SKS kedua semester sama.</p>
@isset($rata)<div class="alert alert-success" role="status">Jumlah IP: {{ $jumlah }}. Rata-rata IPK: <strong>{{ $rata }}</strong>.</div>@endisset
@isset($pesan)<div class="alert alert-danger" role="alert">{{ $pesan }}</div>@endisset
@if($errors->any())<div class="alert alert-danger" role="alert">IP harus berupa angka antara 0 dan 4.</div>@endif
<form method="GET" action="{{ route('ipk.form') }}" class="card p-4"><div class="row g-3">@foreach(['ip1' => 'IP semester 1', 'ip2' => 'IP semester 2'] as $field => $label)<div class="col-md-6"><label for="{{ $field }}" class="form-label">{{ $label }}</label><input class="form-control" id="{{ $field }}" name="{{ $field }}" type="number" min="0" max="4" step="0.01" value="{{ old($field, $$field ?? '') }}" required></div>@endforeach</div><button class="btn btn-primary mt-4 align-self-start">Hitung rata-rata</button></form>
@endsection
