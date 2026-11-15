@extends('layouts.app')
@section('title', 'Rencana riset')
@section('content')
<div class="flex flex-wrap items-start justify-between gap-4">
    <div>
        <span class="badge-its">ResearchMate AI</span>
        <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl">Dari pertanyaan menjadi proyek riset</h1>
        <p class="mt-3 max-w-3xl text-slate-600 dark:text-slate-300">Tinjau kesiapan sumber, simpan rencana ke akun Anda, lalu lihat hasilnya di Proyek Saya.</p>
    </div>
    <a class="text-link" href="{{ route('idea', ['mode' => $dark ? 'light' : 'dark']) }}">{{ $dark ? 'Mode terang' : 'Mode gelap' }}</a>
</div>

@if(session('status'))<x-status-banner type="success" class="mt-6">{{ session('status') }}</x-status-banner>@endif
@if($errors->any())<x-status-banner type="error" class="mt-6">{{ $errors->first() }}</x-status-banner>@endif

<ol id="alur" class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
    @foreach($alur as $langkah)
        <li class="feature-card">
            <p class="eyebrow">Langkah {{ $loop->iteration }}</p>
            <h2 class="mt-2 text-lg font-bold">{{ $langkah['judul'] }}</h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $langkah['isi'] }}</p>
        </li>
    @endforeach
</ol>

<div class="mt-8 grid gap-6 lg:grid-cols-[1.1fr_1fr] lg:items-start">
    <section id="demo-saran" class="feature-card scroll-mt-24">
        <p class="eyebrow">Langkah 1–2 · Mulai di sini</p>
        <h2 class="mt-2 text-2xl font-bold">Rencana penelitian</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Masukkan pertanyaan dan jumlah sumber yang sudah dicatat. Belum perlu mengunggah dokumen.</p>
        @if($plan)
            <p class="mt-4 rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-950 dark:border-blue-900 dark:bg-blue-950/40 dark:text-blue-100">Rencana di samping sudah ditinjau. Jika Anda mengubah isinya, tinjau ulang sebelum menyimpan proyek.</p>
            <details class="mt-5" @if($errors->has('pertanyaan_riset') || $errors->has('mode_riset') || $errors->has('jumlah_artikel') || $errors->has('jumlah_pdf')) open @endif>
                <summary class="cursor-pointer text-sm font-bold text-[#2563eb] dark:text-sky-400">Ubah rencana dan tinjau ulang</summary>
        @endif
        <form method="POST" action="{{ route('research.plan') }}" class="mt-5 space-y-4">
            @csrf
            <input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">
            <div>
                <label for="pertanyaan_riset" class="text-sm font-semibold">Pertanyaan riset</label>
                <textarea id="pertanyaan_riset" name="pertanyaan_riset" rows="4" class="field mt-1" minlength="15" required placeholder="Contoh: Bagaimana metode pembelajaran adaptif memengaruhi keterlibatan mahasiswa?">{{ old('pertanyaan_riset', $plan['data']['pertanyaan_riset'] ?? '') }}</textarea>
                @error('pertanyaan_riset')<p class="error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="mode_riset" class="text-sm font-semibold">Sumber utama</label>
                <select id="mode_riset" name="mode_riset" class="field mt-1" required>
                    <option value="dokumen_lokal" @selected(old('mode_riset', $plan['data']['mode_riset'] ?? 'dokumen_lokal') === 'dokumen_lokal')>Dokumen lokal</option>
                    <option value="penelusuran_literatur" @selected(old('mode_riset', $plan['data']['mode_riset'] ?? '') === 'penelusuran_literatur')>Penelusuran literatur</option>
                </select>
                @error('mode_riset')<p class="error">{{ $message }}</p>@enderror
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div><label for="jumlah_artikel" class="text-sm font-semibold">Artikel dicatat</label><input id="jumlah_artikel" name="jumlah_artikel" type="number" min="0" max="1000" class="field mt-1" value="{{ old('jumlah_artikel', $plan['data']['jumlah_artikel'] ?? 0) }}" required>@error('jumlah_artikel')<p class="error">{{ $message }}</p>@enderror</div>
                <div><label for="jumlah_pdf" class="text-sm font-semibold">PDF dicatat</label><input id="jumlah_pdf" name="jumlah_pdf" type="number" min="0" max="1000" class="field mt-1" value="{{ old('jumlah_pdf', $plan['data']['jumlah_pdf'] ?? 0) }}" required>@error('jumlah_pdf')<p class="error">{{ $message }}</p>@enderror</div>
            </div>
            <button class="button w-full" type="submit">Tinjau langkah berikutnya</button>
        </form>
        @if($plan)</details>@endif
    </section>

    <section id="hasil" class="feature-card scroll-mt-24" aria-live="polite">
        <p class="eyebrow">Langkah 3 · Hasil tinjauan</p>
        <h2 class="mt-2 text-2xl font-bold">Apa yang perlu dilakukan?</h2>
        @if($plan)
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Hasil ini berlaku untuk rencana yang sudah Anda tinjau berikut:</p>
            <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-700 dark:bg-slate-800/60">
                <p class="font-semibold">{{ $plan['data']['pertanyaan_riset'] }}</p>
                <p class="mt-2 text-slate-600 dark:text-slate-300">{{ $plan['data']['jumlah_artikel'] }} artikel · {{ $plan['data']['jumlah_pdf'] }} PDF · {{ $plan['data']['mode_riset'] === 'dokumen_lokal' ? 'Dokumen lokal' : 'Penelusuran literatur' }}</p>
            </div>
            <div class="mt-5 space-y-3">
                @foreach($plan['saran'] as $item)
                    <article class="rounded-lg border border-blue-100 bg-blue-50/60 p-4 dark:border-slate-700 dark:bg-slate-800/60">
                        <h3 class="font-bold">{{ $item['judul'] }}</h3>
                        <p class="mt-1 text-xs font-semibold text-blue-800 dark:text-blue-300">{{ $item['bukti'] }}</p>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $item['isi'] }}</p>
                    </article>
                @endforeach
            </div>
            <a class="text-link mt-5" href="#simpan-proyek">Lanjut simpan proyek →</a>
        @else
            <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">Isi formulir di samping untuk melihat tinjauan awal. Hasilnya akan muncul di sini sebelum Anda menyimpan proyek.</p>
        @endif
    </section>
</div>

@if($plan)
<section id="simpan-proyek" class="feature-card mt-8 scroll-mt-24 border-t-3 border-t-[#f8ac18]">
    <p class="eyebrow">Langkah 4 · Lanjutkan proyek</p>
    <h2 class="mt-2 text-2xl font-bold">Simpan rencana ke Proyek Saya</h2>
    @auth
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Beri judul dan ringkasan. Pertanyaan serta jumlah sumber di atas akan ikut tersimpan pada akun {{ auth()->user()->name }}.</p>
        <form method="POST" action="{{ route('idea.store') }}" class="mt-5 grid gap-4 md:grid-cols-2">
            @csrf
            <input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">
            <input type="hidden" name="plan_token" value="{{ $plan['token'] ?? '' }}">
            <div><label for="judul" class="text-sm font-semibold">Judul proyek</label><input id="judul" name="judul" class="field mt-1" value="{{ old('judul', $draft['judul'] ?? '') }}" minlength="5" maxlength="150" required>@error('judul')<p class="error">{{ $message }}</p>@enderror</div>
            <div><label for="deskripsi" class="text-sm font-semibold">Ringkasan proyek</label><textarea id="deskripsi" name="deskripsi" rows="3" class="field mt-1" minlength="15" maxlength="3000" required>{{ old('deskripsi', $draft['deskripsi'] ?? $plan['data']['pertanyaan_riset']) }}</textarea>@error('deskripsi')<p class="error">{{ $message }}</p>@enderror</div>
            <div class="md:col-span-2"><button class="button" type="submit">Simpan proyek ke akun</button></div>
        </form>
    @else
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Rencana ini sementara tersimpan di sesi browser. Masuk atau buat akun untuk memberi judul, menyimpannya, dan melihatnya di Proyek Saya.</p>
        <div class="mt-5 flex flex-wrap gap-3">
            <a class="button" href="{{ route('login', ['next' => 'research']) }}">Masuk untuk menyimpan</a>
            <a class="button-secondary" href="{{ route('register', ['next' => 'research']) }}">Buat akun</a>
        </div>
    @endauth
</section>
@endif

<section class="feature-card mt-8">
    <p class="eyebrow">Cara kerja saat ini</p>
    <h2 class="mt-2 text-xl font-bold">Tinjauan awal yang dapat diperiksa</h2>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Saran di halaman ini dibuat dari pertanyaan dan jumlah sumber yang Anda masukkan. Layanan chat AI tersedia melalui API terproteksi; formulir ini belum membaca isi PDF. Tinjau dokumen asli sebelum membuat kesimpulan.</p>
    <a class="text-link mt-4" href="{{ route('agent') }}">Lihat rancangan peran agen →</a>
</section>
@endsection
