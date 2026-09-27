@extends('layouts.app')
@section('title', 'Secure Feedback Hub')
@section('content')
<div class="grid gap-8 lg:grid-cols-[1fr_1.3fr] lg:items-start">
    <div>
        <div class="badge-its">
            Secure Feedback Hub
        </div>
        <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white md:text-4xl">Masukan akademik untuk ITS</h1>
        <p class="mt-3 text-base leading-relaxed text-slate-600 dark:text-slate-300">
            Sampaikan saran mengenai akademik, sarana prasarana, atau kegiatan mahasiswa. Masukan Anda diproses secara transparan melalui sesi terverifikasi.
        </p>

        <div class="mt-8 space-y-4">
            <div class="rounded-xl border border-slate-200/90 bg-white p-5 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33]">
                <p class="eyebrow">Jaminan Keamanan & Validasi</p>
                <ul class="mt-3 space-y-2.5 text-sm text-slate-600 dark:text-slate-300">
                    <li class="flex items-center gap-2.5">
                        <span class="grid h-5 w-5 place-items-center rounded-full bg-blue-100 text-xs font-bold text-[#013880] dark:bg-blue-950 dark:text-sky-300">✓</span>
                        <span>Verifikasi domain email resmi mahasiswa ITS</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="grid h-5 w-5 place-items-center rounded-full bg-blue-100 text-xs font-bold text-[#013880] dark:bg-blue-950 dark:text-sky-300">✓</span>
                        <span>Proteksi serangan CSRF dan sanitasi XSS</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="grid h-5 w-5 place-items-center rounded-full bg-blue-100 text-xs font-bold text-[#013880] dark:bg-blue-950 dark:text-sky-300">✓</span>
                        <span>Tantangan matematika acak berbasis sesi (CAPTCHA)</span>
                    </li>
                </ul>
            </div>

            <div class="rounded-xl border border-slate-200/90 bg-white p-5 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33]">
                <p class="eyebrow">Konteks Riset Narafin (Opsional)</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                    Anda juga dapat mengevaluasi skenario saran analitika pemain dari proyek Narafin dengan memilih mode permainan dan indikator yang relevan.
                </p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33] sm:p-7">
        <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Formulir Masukan Mahasiswa</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Isi data di bawah dengan benar. Nilai isian lama dipertahankan jika terjadi kesalahan.</p>

        @if($errors->any())
            <div class="mt-5 rounded-lg border border-rose-200 bg-rose-50/90 p-4 text-sm font-semibold text-rose-900 dark:border-rose-900/60 dark:bg-rose-950/60 dark:text-rose-200" role="alert">
                Periksa kolom yang ditandai sebelum mengirim masukan.
            </div>
        @endif

        <form method="POST" action="{{ route('feedback.store') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Nama mahasiswa</label>
                <input id="nama" name="nama" type="text" class="field" value="{{ old('nama') }}" placeholder="Nama lengkap Anda" required>
                @error('nama')<p class="error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Email mahasiswa ITS</label>
                <input id="email" name="email" type="email" class="field" value="{{ old('email') }}" placeholder="nama@student.its.ac.id" required>
                @error('email')<p class="error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="kategori" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Kategori masukan</label>
                <select id="kategori" name="kategori" class="field" required>
                    <option value="">Pilih kategori masukan</option>
                    @foreach($kategori as $item)
                        <option value="{{ $item }}" @selected(old('kategori') === $item)>{{ $item }}</option>
                    @endforeach
                </select>
                @error('kategori')<p class="error">{{ $message }}</p>@enderror
            </div>

            <fieldset class="rounded-lg border border-slate-200 p-4 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/40">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Konteks Narafin (opsional)</legend>
                <div class="grid gap-4 sm:grid-cols-2 mt-2">
                    <div>
                        <label for="mode_permainan" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Mode permainan</label>
                        <select id="mode_permainan" name="mode_permainan" class="field text-sm">
                            <option value="">Tanpa konteks</option>
                            @foreach(['pemula' => 'Pemula', 'mahir' => 'Mahir'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('mode_permainan') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('mode_permainan')<p class="error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="indikator" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Indikator</label>
                        <select id="indikator" name="indikator" class="field text-sm">
                            <option value="">Tanpa indikator</option>
                            @foreach($profil['ai']['indikator'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('indikator') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('indikator')<p class="error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </fieldset>

            <div>
                <label for="pesan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Isi pesan</label>
                <textarea id="pesan" name="pesan" rows="4" class="field" placeholder="Tulis masukan akademik atau kritik konstruktif..." minlength="15" required>{{ old('pesan') }}</textarea>
                @error('pesan')<p class="error">{{ $message }}</p>@enderror
            </div>

            <div class="rounded-lg border border-blue-200/90 bg-blue-50/50 p-4 dark:border-blue-900/60 dark:bg-blue-950/30">
                <label for="captcha" class="block text-sm font-bold text-[#013880] dark:text-sky-200">
                    Berapakah {{ $captcha[0] }} + {{ $captcha[1] }}?
                </label>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-400">Verifikasi keamanan sesi untuk memastikan pengirim bukan bot.</p>
                <input id="captcha" name="captcha" type="number" step="1" class="field mt-2 max-w-xs" placeholder="Jawaban angka" value="{{ old('captcha') }}" required>
                @error('captcha')<p class="error">{{ $message }}</p>@enderror
            </div>

            <button class="button w-full sm:w-auto">
                <span>Kirim masukan</span>
                <span aria-hidden="true">→</span>
            </button>
        </form>
    </div>
</div>
@endsection

