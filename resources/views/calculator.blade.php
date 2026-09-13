@extends('layouts.app')
@section('title', 'Kalkulator Dinamis')
@section('content')
<p class="eyebrow muted">Challenge 01</p><h1>Kalkulator dinamis</h1>
@isset($hasil)<div class="alert alert-success mt-4" role="status">Hasil dari {{ $angka1 }} {{ $operasi }} {{ $angka2 }} adalah {{ $hasil }}</div>@endisset
@isset($pesan)<div class="alert alert-danger mt-4" role="alert">{{ $pesan }}</div>@endisset
@if($errors->any())<div class="alert alert-danger mt-4" role="alert">Periksa angka dan operasi yang dimasukkan.</div>@endif
<form method="GET" action="{{ route('calculator') }}" class="card p-4 mt-4">
    <div class="row g-3">
        <div class="col-md-4"><label for="angka1" class="form-label">Angka pertama</label><input id="angka1" name="angka1" type="number" step="any" min="-1000000000000" max="1000000000000" class="form-control" value="{{ old('angka1', $angka1 ?? 10) }}" required></div>
        <div class="col-md-4"><label for="operasi" class="form-label">Operasi</label><select id="operasi" name="operasi" class="form-select">@foreach(['tambah', 'kurang', 'kali', 'bagi'] as $op)<option value="{{ $op }}" @selected(old('operasi', $operasi ?? 'kali') === $op)>{{ ucfirst($op) }}</option>@endforeach</select></div>
        <div class="col-md-4"><label for="angka2" class="form-label">Angka kedua</label><input id="angka2" name="angka2" type="number" step="any" min="-1000000000000" max="1000000000000" class="form-control" value="{{ old('angka2', $angka2 ?? 5) }}" required></div>
    </div>
    <button class="btn btn-primary mt-4 align-self-start">Hitung hasil</button>
</form>
@endsection
