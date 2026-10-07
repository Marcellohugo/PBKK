@extends('layouts.app')
@section('title', 'Kalkulator')
@section('content')
<div class="max-w-4xl border-b border-slate-200/80 pb-6 dark:border-slate-800/80">
    <div class="badge-its">
        Alat hitung tambahan
    </div>
    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl">Kalkulator</h1>
    <p class="mt-3 max-w-2xl text-base text-slate-600 dark:text-slate-300">
        Hitung operasi dasar dan rata-rata IP dua semester. Setiap input diperiksa sebelum hasil ditampilkan.
    </p>
</div>

<div class="mt-8 grid gap-8 lg:grid-cols-2">
    {{-- Aritmetika Section --}}
    <section id="aritmetika" class="scroll-mt-10" aria-labelledby="aritmetika-title">
        <div class="h-full rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33] flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
                    <div>
                        <p class="eyebrow">Modul 01</p>
                        <h2 id="aritmetika-title" class="mt-1 text-xl font-bold tracking-tight text-slate-900 dark:text-white">Aritmetika Dinamis</h2>
                    </div>
                    <span class="rounded bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        2 Parameter
                    </span>
                </div>

                @isset($hasil)
                <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50/90 p-5 text-[#013880] shadow-2xs dark:border-blue-900 dark:bg-blue-950/40 dark:text-sky-200" role="status">
                    <p class="eyebrow">Hasil Perhitungan</p>
                    <p class="mt-1 text-3xl font-black">Hasil: {{ $hasil }}</p>
                </div>
                @endisset

                @if($errors->hasAny(['angka1','angka2','operasi']) || isset($pesan))
                <div class="mt-5 rounded-lg border border-rose-200 bg-rose-50/90 p-4 text-sm font-semibold text-rose-900 dark:border-rose-900/60 dark:bg-rose-950/60 dark:text-rose-200" role="alert">
                    {{ $pesan ?? $errors->first() }}
                </div>
                @endif

                <form class="mt-6 space-y-4" method="GET" action="{{ route('calculator') }}">
                    <div>
                        <label for="angka1" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Angka pertama</label>
                        <input id="angka1" class="field" type="number" step="any" name="angka1" value="{{ old('angka1', $angka1 ?? '') }}" placeholder="Contoh: 10" required>
                    </div>

                    <div>
                        <label for="operasi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Operasi matematika</label>
                        <select id="operasi" class="field" name="operasi">
                            @foreach(['tambah' => 'Tambah (+)', 'kurang' => 'Kurang (−)', 'kali' => 'Kali (×)', 'bagi' => 'Bagi (÷)'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('operasi', $operasi ?? '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="angka2" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Angka kedua</label>
                        <input id="angka2" class="field" type="number" step="any" name="angka2" value="{{ old('angka2', $angka2 ?? '') }}" placeholder="Contoh: 5" required>
                    </div>

                    <button class="button mt-2 w-full sm:w-auto">Hitung hasil</button>
                </form>
            </div>
        </div>
    </section>

    {{-- IPK Section --}}
    <section id="ipk" class="scroll-mt-10" aria-labelledby="ipk-title">
        <div class="h-full rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33] flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
                    <div>
                        <p class="eyebrow">Modul 02</p>
                        <h2 id="ipk-title" class="mt-1 text-xl font-bold tracking-tight text-slate-900 dark:text-white">Rata-rata Dua IP</h2>
                    </div>
                    <span class="rounded bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        Skala 0.00 – 4.00
                    </span>
                </div>

                @isset($rata)
                <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50/90 p-5 text-amber-950 shadow-2xs dark:border-amber-900 dark:bg-amber-950/40 dark:text-amber-200" role="status">
                    <p class="eyebrow text-amber-700 dark:text-amber-300">Indeks Prestasi Kumulatif</p>
                    <p class="mt-1 text-3xl font-black">IPK: {{ $rata }} <span class="text-sm font-normal text-slate-600 dark:text-slate-300">(jumlah IP {{ $jumlah }})</span></p>
                </div>
                @endisset

                @if($errors->hasAny(['ip1','ip2']) || isset($ipkPesan))
                <div class="mt-5 rounded-lg border border-rose-200 bg-rose-50/90 p-4 text-sm font-semibold text-rose-900 dark:border-rose-900/60 dark:bg-rose-950/60 dark:text-rose-200" role="alert">
                    {{ $ipkPesan ?? $errors->first() }}
                </div>
                @endif

                <form class="mt-6 space-y-4" method="GET" action="{{ route('ipk.form') }}">
                    <div>
                        <label for="ip1" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">IP semester 1</label>
                        <input id="ip1" class="field" type="number" min="0" max="4" step="0.01" name="ip1" value="{{ old('ip1', $ip1 ?? '') }}" placeholder="0.00 – 4.00" required>
                    </div>

                    <div>
                        <label for="ip2" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">IP semester 2</label>
                        <input id="ip2" class="field" type="number" min="0" max="4" step="0.01" name="ip2" value="{{ old('ip2', $ip2 ?? '') }}" placeholder="0.00 – 4.00" required>
                    </div>

                    <button class="button mt-2 w-full sm:w-auto">Hitung IPK</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

