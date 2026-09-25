@extends('layouts.app')
@section('title', 'Kalkulator IPK')
@section('content')
<h1 class="text-4xl font-bold">Kalkulator IPK</h1><p class="mt-3">Rata-rata dua IP semester dengan bobot sama.</p>
<form class="mt-8 grid max-w-2xl gap-4 rounded-2xl bg-white p-6 shadow-sm dark:bg-slate-900" method="GET" action="{{ route('ipk.form') }}">@foreach(['ip1' => 'IP semester 1', 'ip2' => 'IP semester 2'] as $key => $label)<label class="grid gap-2">{{ $label }}<input class="rounded-lg border border-slate-300 p-3 text-slate-900" type="number" step="0.01" min="0" max="4" name="{{ $key }}" value="{{ old($key, ${$key} ?? '') }}" required></label>@endforeach<button class="rounded-xl bg-sky-900 px-5 py-3 font-semibold text-white">Hitung IPK</button></form>
@if($errors->any() || isset($pesan))<p class="mt-5 text-red-700" role="alert">{{ $pesan ?? $errors->first() }}</p>@endif
@isset($rata)<p class="mt-6 text-2xl font-bold" role="status">IPK: {{ $rata }} <span class="text-base font-normal">(jumlah IP {{ $jumlah }})</span></p>@endisset
@endsection
