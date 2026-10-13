@extends('layouts.app')
@section('title', 'Rencana riset')
@section('content')
<div class="grid gap-8 lg:grid-cols-[1.3fr_1fr] lg:items-start">
    <div>
        <span class="badge-its">ResearchMate AI</span>
        <a class="text-link ml-3" href="{{ route('idea', ['mode' => $dark ? 'light' : 'dark']) }}">{{ $dark ? 'Mode terang' : 'Mode gelap' }}</a>
        <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-950 dark:text-white">Mulai dari pertanyaan yang jelas</h1>
        <p class="mt-4 max-w-2xl text-slate-600 dark:text-slate-300">Catat arah penelitian dan jumlah sumber yang sudah Anda miliki. Ruang ini memberi panduan awal yang dapat Anda periksa sebelum menelaah artikel dan PDF.</p>
        <div id="alur" class="mt-8 grid gap-3 sm:grid-cols-2">
            @foreach($alur as $langkah)
                <x-info-card :title="$langkah['judul']" :label="'0'.$loop->iteration">{{ $langkah['isi'] }}</x-info-card>
            @endforeach
        </div>
        <div class="mt-8 feature-card">
            <p class="eyebrow">Alur ResearchMate</p>
            <h2 class="mt-2 text-xl font-bold">Dari sumber ke kesimpulan</h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Dalam platform ResearchMate, artikel dan PDF mendukung matriks literatur, kandidat celah riset, dan laporan dengan rujukan. Form di halaman ini meninjau kesiapan awal dari angka yang Anda masukkan; ia belum membaca dokumen atau menjalankan model AI.</p>
            <a class="text-link mt-4" href="{{ route('agent') }}">Lihat peran agen riset →</a>
        </div>
        <div class="mt-6 feature-card">
            <p class="eyebrow">Fokus penelitian</p>
            <h2 class="mt-2 text-xl font-bold">Ajukan ide riset</h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Validasi ringkasan ide sebelum dibahas bersama tim. Form ini tidak menyimpan proyek ke daftar akun.</p>
            @if(session('status'))<x-status-banner type="success" class="mt-4">{{ session('status') }}</x-status-banner>@endif
            <form method="POST" action="{{ route('idea.store') }}" class="mt-5 space-y-4">
                @csrf
                <input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">
                <div><label for="nama" class="text-sm font-semibold">Nama pengusul</label><input id="nama" name="nama" class="field mt-1" value="{{ old('nama') }}" required>@error('nama')<p class="error">{{ $message }}</p>@enderror</div>
                <div><label for="judul" class="text-sm font-semibold">Judul ide</label><input id="judul" name="judul" class="field mt-1" value="{{ old('judul') }}" required>@error('judul')<p class="error">{{ $message }}</p>@enderror</div>
                <div><label for="deskripsi" class="text-sm font-semibold">Deskripsi riset</label><textarea id="deskripsi" name="deskripsi" rows="3" class="field mt-1" required>{{ old('deskripsi') }}</textarea>@error('deskripsi')<p class="error">{{ $message }}</p>@enderror</div>
                <button type="submit" class="button-secondary">Periksa ide</button>
            </form>
        </div>
    </div>

    <div id="demo-saran" class="feature-card scroll-mt-24">
        <p class="eyebrow">Tinjauan awal</p>
        <h2 class="mt-2 text-2xl font-bold">Rencana penelitian</h2>
        <form method="POST" action="{{ route('research.plan') }}" class="mt-5 space-y-4">
            @csrf
            <input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">
            <div><label for="pertanyaan_riset" class="text-sm font-semibold">Pertanyaan riset</label><textarea id="pertanyaan_riset" name="pertanyaan_riset" rows="4" class="field mt-1" minlength="15" required placeholder="Contoh: Bagaimana metode pembelajaran adaptif memengaruhi keterlibatan mahasiswa?">{{ old('pertanyaan_riset') }}</textarea>@error('pertanyaan_riset')<p class="error">{{ $message }}</p>@enderror</div>
            <div><label for="mode_riset" class="text-sm font-semibold">Sumber utama</label><select id="mode_riset" name="mode_riset" class="field mt-1" required><option value="dokumen_lokal" @selected(old('mode_riset') === 'dokumen_lokal')>Dokumen lokal</option><option value="penelusuran_literatur" @selected(old('mode_riset') === 'penelusuran_literatur')>Penelusuran literatur</option></select>@error('mode_riset')<p class="error">{{ $message }}</p>@enderror</div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div><label for="jumlah_artikel" class="text-sm font-semibold">Artikel dicatat</label><input id="jumlah_artikel" name="jumlah_artikel" type="number" min="0" max="1000" class="field mt-1" value="{{ old('jumlah_artikel', 0) }}" required>@error('jumlah_artikel')<p class="error">{{ $message }}</p>@enderror</div>
                <div><label for="jumlah_pdf" class="text-sm font-semibold">PDF tersedia</label><input id="jumlah_pdf" name="jumlah_pdf" type="number" min="0" max="1000" class="field mt-1" value="{{ old('jumlah_pdf', 0) }}" required>@error('jumlah_pdf')<p class="error">{{ $message }}</p>@enderror</div>
            </div>
            <button class="button w-full" type="submit">Tinjau rencana</button>
        </form>
        @if(session('analitika'))
            <div class="mt-7 border-t border-slate-200 pt-6 dark:border-slate-800" aria-live="polite">
                <h3 class="text-lg font-bold">Langkah berikutnya</h3>
                <div class="mt-4 space-y-3">
                    @foreach(session('analitika.saran') as $item)
                        <article class="rounded-lg border border-blue-100 bg-blue-50/60 p-4 dark:border-slate-700 dark:bg-slate-800/60"><h4 class="font-bold">{{ $item['judul'] }}</h4><p class="mt-1 text-xs font-semibold text-blue-800 dark:text-blue-300">{{ $item['bukti'] }}</p><p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $item['isi'] }}</p></article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
