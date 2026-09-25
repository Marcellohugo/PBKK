@extends('layouts.app')
@section('title', 'Kalkulator')
@section('content')
<h1 class="text-4xl font-bold">Kalkulator aritmetika</h1><p class="mt-3">Hitung dua angka melalui parameter rute.</p>
<form class="mt-8 grid max-w-2xl gap-4 rounded-2xl bg-white p-6 shadow-sm dark:bg-slate-900" method="GET" action="{{ route('calculator') }}">
@foreach(['angka1' => 'Angka pertama', 'angka2' => 'Angka kedua'] as $key => $label)<label class="grid gap-2">{{ $label }}<input class="rounded-lg border border-slate-300 p-3 text-slate-900" type="number" step="any" name="{{ $key }}" value="{{ old($key, ${$key} ?? '') }}" required></label>@endforeach
<label class="grid gap-2">Operasi<select class="rounded-lg border border-slate-300 p-3 text-slate-900" name="operasi">@foreach(['tambah' => 'Tambah', 'kurang' => 'Kurang', 'kali' => 'Kali', 'bagi' => 'Bagi'] as $value => $label)<option value="{{ $value }}" @selected(old('operasi', $operasi ?? '') === $value)>{{ $label }}</option>@endforeach</select></label>
<button class="rounded-xl bg-sky-900 px-5 py-3 font-semibold text-white">Hitung</button></form>
@if($errors->any() || isset($pesan))<p class="mt-5 text-red-700" role="alert">{{ $pesan ?? $errors->first() }}</p>@endif
@isset($hasil)<p class="mt-6 text-2xl font-bold" role="status">Hasil: {{ $hasil }}</p>@endisset
@endsection
