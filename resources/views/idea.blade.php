@extends('layouts.app')
@section('title', 'Ide Agentic AI')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200/80 pb-5 dark:border-slate-800/80">
    <div class="badge-its">
        {{ $profil['ai']['fase'] }}
    </div>
    <a class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-2xs transition-all hover:bg-slate-50 hover:border-slate-400 dark:border-slate-700 dark:bg-[#0b1c33] dark:text-slate-200 dark:hover:bg-slate-800" 
       href="{{ route('idea', ['mode' => $dark ? 'light' : 'dark', 'permainan' => $permainan]) }}">
        <span>{{ $dark ? '☀️ Mode Terang' : '🌙 Mode Gelap' }}</span>
    </a>
</div>

<div class="mt-6 max-w-4xl">
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl lg:text-5xl leading-tight">{{ $profil['tema'] }}</h1>
    <p class="mt-4 text-base leading-relaxed text-slate-600 dark:text-slate-300">{{ $profil['deskripsi'] }}</p>
</div>

<section class="mt-10" aria-labelledby="alur">
    <div class="flex items-center justify-between">
        <div>
            <h2 id="alur" class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Rancangan alur Agentic AI</h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Alur berikut merupakan rencana proyek akhir. Demo metrik di bawah menjalankan perhitungan lokal.</p>
        </div>
    </div>
    <ol class="mt-6 grid gap-5 sm:grid-cols-2">
        @foreach($alur as $langkah)
        <li class="h-full">
            <x-info-card :title="$langkah['judul']" :label="'Langkah '.$loop->iteration" class="h-full border-t-3 border-t-[#013880]">
                <p class="leading-relaxed">{{ $langkah['isi'] }}</p>
            </x-info-card>
        </li>
        @endforeach
    </ol>
</section>

<div class="mt-6 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200/90 bg-white p-4 text-sm text-slate-600 dark:border-slate-800 dark:bg-[#0b1c33] dark:text-slate-400">
    <p>
        Referensi rancangan: <a class="underline font-semibold text-[#013880] dark:text-sky-300" href="{{ $profil['ai']['sumber'] }}" target="_blank" rel="noopener">Narafin · Analitika Pemain, bagian Saran</a>. Pengembangan berikutnya mengirim metrik yang sudah dihitung ke LLM untuk penjelasan kontekstual dan tinjauan instruktur.
    </p>
    <a class="text-link shrink-0" href="{{ route('agent') }}">Jelajahi skenario agent menurut mode →</a>
</div>

<section id="demo-saran" class="mt-12 scroll-mt-10" aria-labelledby="demo-title">
    <div class="rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33] sm:p-7">
        <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-200/80 pb-5 dark:border-slate-800/80">
            <div>
                <p class="eyebrow">Simulasi Metrik Real-Time</p>
                <h2 id="demo-title" class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Demo saran analitika pemain</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Ubah metrik untuk melihat saran beserta bukti angka. Data contoh adalah simulasi; saran dihasilkan aturan deterministik, belum oleh LLM.</p>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Pilih mode:</span>
                <div class="inline-flex rounded-md border border-slate-300 bg-slate-100 p-1 dark:border-slate-700 dark:bg-slate-900" aria-label="Pilih mode permainan">
                    @foreach(['pemula' => 'Pemula', 'mahir' => 'Mahir'] as $value => $label)
                    <a class="rounded px-4 py-1.5 text-xs font-bold transition-all {{ $permainan === $value ? 'bg-[#013880] text-white shadow-2xs dark:bg-sky-600' : 'text-slate-700 hover:text-[#013880] dark:text-slate-400 dark:hover:text-white' }}" 
                       href="{{ route('idea', ['mode' => $dark ? 'dark' : 'light', 'permainan' => $value]) }}#demo-saran" 
                       @if($permainan === $value) aria-current="true" @endif>
                       {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <p class="mt-4 text-xs font-semibold text-slate-500 dark:text-slate-400">
            Mode {{ ucfirst($permainan) }}{{ $permainan === 'pemula' ? ': indikator pinjaman tidak digunakan.' : ': pinjaman menjadi prioritas pembahasan jika belum lunas.' }}
        </p>

        @error('mode_permainan')<p class="error mt-3">{{ $message }}</p>@enderror
        @if($errors->hasAny(['mode_permainan', 'koin_awal', 'koin_akhir', 'bahan_terkumpul', 'bahan_terpakai', 'sisa_pinjaman']))
            <x-status-banner type="error" class="mt-4">Metrik belum diproses. Periksa kolom di bawah.</x-status-banner>
        @endif

        <form method="POST" action="{{ route('player.advice') }}" class="mt-6 grid gap-5 sm:grid-cols-2 rounded-lg bg-slate-50/70 p-5 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-800">
            @csrf
            <input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">
            <input type="hidden" name="mode_permainan" value="{{ $permainan }}">

            @foreach(['koin_awal' => ['Koin awal', 20, 1, 1000000], 'koin_akhir' => ['Koin akhir', 12, 0, 1000000], 'bahan_terkumpul' => ['Bahan terkumpul (kartu)', 10, 0, 100000], 'bahan_terpakai' => ['Bahan terpakai (kartu)', 4, 0, 100000]] as $field => $spec)
            <div>
                <label for="{{ $field }}" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ $spec[0] }}</label>
                <input id="{{ $field }}" name="{{ $field }}" type="number" step="1" min="{{ $spec[2] }}" max="{{ $spec[3] }}" 
                       class="field text-sm" value="{{ old($field, $spec[1]) }}" aria-describedby="{{ $field }}-error" @if(str_starts_with($field, 'koin')) required @endif>
                @error($field)<p id="{{ $field }}-error" class="error">{{ $message }}</p>@enderror
            </div>
            @endforeach

            @if($permainan === 'mahir')
            <div class="sm:col-span-2">
                <label for="sisa_pinjaman" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Sisa pokok pinjaman (koin)</label>
                <input id="sisa_pinjaman" name="sisa_pinjaman" type="number" min="0" max="1000000" step="1" 
                       class="field text-sm" value="{{ old('sisa_pinjaman', 6) }}" aria-describedby="sisa_pinjaman-error">
                @error('sisa_pinjaman')<p id="sisa_pinjaman-error" class="error">{{ $message }}</p>@enderror
            </div>
            @endif

            <div class="sm:col-span-2 pt-3 flex flex-wrap items-center justify-between gap-4 border-t border-slate-200/80 dark:border-slate-800">
                <p class="text-xs text-slate-500 dark:text-slate-400">Kosongkan kedua kolom bahan jika belum tersedia. Sisa pinjaman 0 berarti lunas; kolom kosong berarti belum diketahui.</p>
                <button class="button">Susun saran dari metrik</button>
            </div>
        </form>

        @if(session('analitika'))
        <div class="mt-8 border-t border-slate-200/80 pt-6 dark:border-slate-800" aria-live="polite">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Hasil saran · {{ ucfirst(session('analitika.data.mode_permainan')) }}</h3>
                <span class="badge-its">
                    Saran Dihitung Berbasis Bukti
                </span>
            </div>
            <div class="grid gap-5 md:grid-cols-3">
                @foreach(session('analitika.saran') as $item)
                <x-info-card :title="$item['judul']" label="Saran berdasarkan input" 
                             class="{{ str_contains($item['judul'], 'Prioritas') ? 'border-amber-300 bg-amber-50/40 dark:border-amber-700 dark:bg-amber-950/20' : 'border-t-3 border-t-[#013880]' }}">
                    <div class="space-y-3">
                        <p class="rounded-md bg-slate-50 dark:bg-slate-800/80 p-3 text-xs font-mono font-semibold text-slate-800 dark:text-slate-200 border border-slate-200/80 dark:border-slate-700/80">
                            {{ $item['bukti'] }}
                        </p>
                        <p class="text-sm leading-relaxed text-slate-700 dark:text-slate-300">{{ $item['isi'] }}</p>
                    </div>
                </x-info-card>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<section id="form-ide" class="mt-12 max-w-3xl scroll-mt-10">
    <div class="rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33] sm:p-7">
        <p class="eyebrow">Kolaborasi Proyek</p>
        <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Kirim ide pengembangan</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Form latihan lokal. Ide ditampilkan sebagai konfirmasi sesi, belum disimpan ke database.</p>

        @if(session('status'))
            <x-status-banner type="success" class="mt-5">{{ session('status') }}</x-status-banner>
        @endif

        @if(session('ide'))
            <x-info-card :title="session('ide.judul')" label="Ide yang baru diajukan" class="mt-5 border-blue-300 dark:border-blue-700">
                <p class="whitespace-pre-wrap leading-relaxed">{{ session('ide.deskripsi') }}</p>
            </x-info-card>
        @endif

        @if($errors->hasAny(['nama', 'judul', 'deskripsi', 'mode']))
            <x-status-banner type="error" class="mt-5">Ide belum diproses. Periksa kembali kolom di bawah.</x-status-banner>
        @endif

        <form method="POST" action="{{ route('idea.store') }}" class="mt-6 space-y-5">
            @csrf
            <input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">

            <div>
                <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Nama pengusul</label>
                <input id="nama" name="nama" class="field" value="{{ old('nama', config('profile.nama')) }}" minlength="3" maxlength="100" autocomplete="name" aria-describedby="nama-error" required>
                @error('nama')<p id="nama-error" class="error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="judul" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Judul ide</label>
                <input id="judul" name="judul" class="field" value="{{ old('judul') }}" minlength="5" maxlength="150" aria-describedby="judul-error" required>
                @error('judul')<p id="judul-error" class="error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Deskripsi ide</label>
                <textarea id="deskripsi" name="deskripsi" class="field" rows="4" minlength="15" maxlength="3000" aria-describedby="deskripsi-error" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<p id="deskripsi-error" class="error">{{ $message }}</p>@enderror
            </div>

            <button class="button">Kirim ide</button>
        </form>
    </div>
</section>
@endsection

