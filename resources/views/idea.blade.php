@extends('layouts.app')
@section('title', 'Ide Agentic AI')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-4"><p class="eyebrow">{{ $profil['ai']['fase'] }}</p><a class="rounded-xl border border-slate-300 px-4 py-2 text-sm dark:border-slate-600" href="{{ route('idea', ['mode' => $dark ? 'light' : 'dark', 'permainan' => $permainan]) }}">{{ $dark ? 'Gunakan mode terang' : 'Gunakan mode gelap' }}</a></div>
<h1 class="mt-4 max-w-4xl text-3xl font-bold leading-tight md:text-5xl">{{ $profil['tema'] }}</h1><p class="mt-5 max-w-3xl text-lg text-slate-600 dark:text-slate-300">{{ $profil['deskripsi'] }}</p>
<section class="mt-9" aria-labelledby="alur"><h2 id="alur" class="text-xl font-bold">Rancangan alur Agentic AI</h2><p class="mt-2 text-slate-600 dark:text-slate-300">Alur berikut merupakan rencana proyek akhir. Demo metrik di bawah menjalankan perhitungan lokal.</p><ol class="mt-5 grid gap-4 sm:grid-cols-2">@foreach($alur as $langkah)<li><x-info-card :title="$langkah['judul']" :label="'Langkah '.$loop->iteration" class="h-full"><p>{{ $langkah['isi'] }}</p></x-info-card></li>@endforeach</ol></section>
<p class="mt-5 text-sm text-slate-600 dark:text-slate-400">Referensi rancangan: <a class="underline" href="{{ $profil['ai']['sumber'] }}" target="_blank" rel="noopener">Narafin · Analitika Pemain, bagian Saran</a>. Pengembangan berikutnya mengirim metrik yang sudah dihitung ke LLM untuk penjelasan kontekstual dan tinjauan instruktur.</p>
<section id="demo-saran" class="mt-12" aria-labelledby="demo-title">
    <h2 id="demo-title" class="text-2xl font-bold">Demo saran analitika pemain</h2>
    <p class="mt-2 text-slate-600 dark:text-slate-300">Ubah metrik untuk melihat saran beserta bukti angka. Data contoh adalah simulasi; saran dihasilkan aturan deterministik, belum oleh LLM.</p>
    <div class="mt-5 flex flex-wrap gap-3" aria-label="Pilih mode permainan">@foreach(['pemula' => 'Pemula', 'mahir' => 'Mahir'] as $value => $label)<a class="rounded-xl border px-4 py-2 {{ $permainan === $value ? 'border-sky-600 font-bold' : 'border-slate-300 dark:border-slate-600' }}" href="{{ route('idea', ['mode' => $dark ? 'dark' : 'light', 'permainan' => $value]) }}#demo-saran" @if($permainan === $value) aria-current="true" @endif>{{ $label }}</a>@endforeach</div>
    <p class="mt-3 text-sm">Mode {{ ucfirst($permainan) }}{{ $permainan === 'pemula' ? ': indikator pinjaman tidak digunakan.' : ': pinjaman menjadi prioritas pembahasan jika belum lunas.' }}</p>
    @error('mode_permainan')<p class="error">{{ $message }}</p>@enderror
    @if($errors->hasAny(['mode_permainan', 'koin_awal', 'koin_akhir', 'bahan_terkumpul', 'bahan_terpakai', 'sisa_pinjaman']))<x-status-banner type="error" class="mt-4">Metrik belum diproses. Periksa kolom di bawah.</x-status-banner>@endif
    <form method="POST" action="{{ route('player.advice') }}" class="mt-6 grid gap-5 rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-700 dark:bg-slate-900 sm:grid-cols-2">
        @csrf
        <input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">
        <input type="hidden" name="mode_permainan" value="{{ $permainan }}">
        @foreach(['koin_awal' => ['Koin awal', 20, 1, 1000000], 'koin_akhir' => ['Koin akhir', 12, 0, 1000000], 'bahan_terkumpul' => ['Bahan terkumpul (kartu)', 10, 0, 100000], 'bahan_terpakai' => ['Bahan terpakai (kartu)', 4, 0, 100000]] as $field => $spec)
        <div><label for="{{ $field }}" class="font-semibold">{{ $spec[0] }}</label><input id="{{ $field }}" name="{{ $field }}" type="number" step="1" min="{{ $spec[2] }}" max="{{ $spec[3] }}" class="field" value="{{ old($field, $spec[1]) }}" aria-describedby="{{ $field }}-error" @if(str_starts_with($field, 'koin')) required @endif>@error($field)<p id="{{ $field }}-error" class="error">{{ $message }}</p>@enderror</div>
        @endforeach
        @if($permainan === 'mahir')<div><label for="sisa_pinjaman" class="font-semibold">Sisa pokok pinjaman (koin)</label><input id="sisa_pinjaman" name="sisa_pinjaman" type="number" min="0" max="1000000" step="1" class="field" value="{{ old('sisa_pinjaman', 6) }}" aria-describedby="sisa_pinjaman-error">@error('sisa_pinjaman')<p id="sisa_pinjaman-error" class="error">{{ $message }}</p>@enderror</div>@endif
        <div class="sm:col-span-2"><p class="mb-4 text-sm text-slate-600 dark:text-slate-300">Kosongkan kedua kolom bahan jika belum tersedia. Sisa pinjaman 0 berarti lunas; kolom kosong berarti belum diketahui.</p><button class="button">Susun saran dari metrik</button></div>
    </form>
    @if(session('analitika'))<div class="mt-6" aria-live="polite"><h3 class="mb-4 text-xl font-bold">Hasil saran · {{ ucfirst(session('analitika.data.mode_permainan')) }}</h3><div class="grid gap-4 md:grid-cols-3">@foreach(session('analitika.saran') as $item)<x-info-card :title="$item['judul']" label="Saran berdasarkan input"><p class="mb-3 font-semibold">{{ $item['bukti'] }}</p><p>{{ $item['isi'] }}</p></x-info-card>@endforeach</div></div>@endif
</section>
<section id="form-ide" class="mt-12 max-w-3xl"><h2 class="text-2xl font-bold">Kirim ide pengembangan</h2><p class="mt-2 text-slate-600 dark:text-slate-300">Form latihan lokal. Ide ditampilkan sebagai konfirmasi sesi, belum disimpan ke database.</p>
@if(session('status'))<x-status-banner type="success" class="mt-5">{{ session('status') }}</x-status-banner>@endif
@if(session('ide'))<x-info-card :title="session('ide.judul')" label="Ide yang baru diajukan" class="mt-5"><p class="whitespace-pre-wrap">{{ session('ide.deskripsi') }}</p></x-info-card>@endif
@if($errors->hasAny(['nama', 'judul', 'deskripsi', 'mode']))<x-status-banner type="error" class="mt-5">Ide belum diproses. Periksa kembali kolom di bawah.</x-status-banner>@endif
<form method="POST" action="{{ route('idea.store') }}" class="mt-6 space-y-5">
@csrf
<input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">
<div><label for="nama" class="font-semibold">Nama pengusul</label><input id="nama" name="nama" class="field" value="{{ old('nama', config('profile.nama')) }}" minlength="3" maxlength="100" autocomplete="name" aria-describedby="nama-error" required>@error('nama')<p id="nama-error" class="error">{{ $message }}</p>@enderror</div>
<div><label for="judul" class="font-semibold">Judul ide</label><input id="judul" name="judul" class="field" value="{{ old('judul') }}" minlength="5" maxlength="150" aria-describedby="judul-error" required>@error('judul')<p id="judul-error" class="error">{{ $message }}</p>@enderror</div>
<div><label for="deskripsi" class="font-semibold">Deskripsi ide</label><textarea id="deskripsi" name="deskripsi" class="field" rows="4" minlength="15" maxlength="3000" aria-describedby="deskripsi-error" required>{{ old('deskripsi') }}</textarea>@error('deskripsi')<p id="deskripsi-error" class="error">{{ $message }}</p>@enderror</div>
<button class="button">Kirim ide</button>
</form></section>
@endsection
