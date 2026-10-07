@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<x-status-banner class="mb-6">Selamat datang, {{ $user }}!</x-status-banner>

<section class="hero-panel p-6 sm:p-8 lg:p-10 border-t-4 border-t-[#f8ac18]">
    <div class="grid gap-8 lg:grid-cols-[1.5fr_1fr] lg:items-center">
        <div>
            <div class="inline-flex items-center gap-2 rounded-md bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-300 border border-white/15">
                Portal PBKK · Teknik Informatika ITS
            </div>
            <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight text-white md:text-4xl lg:text-5xl">
                Portofolio Akademik &<br>Laboratorium PBKK
            </h1>
            <p class="mt-4 max-w-xl text-base text-blue-100/90 leading-relaxed">
                Ruang implementasi praktikum Pemrograman Berbasis Kerangka Kerja oleh <strong>{{ $profil['nama'] }}</strong>. Menyajikan eksplorasi routing Laravel, validasi data, serta perancangan analitika Narafin AI Coach.
            </p>
            <div class="mt-7 flex flex-wrap gap-3">
                <a class="button-gold" href="{{ route('idea') }}#demo-saran">
                    <span>Coba Demo Saran AI</span>
                    <span aria-hidden="true">→</span>
                </a>
                <a class="inline-flex items-center justify-center gap-2 rounded-md border border-white/30 bg-white/10 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/20" href="{{ route('profile') }}">
                    <span>Lihat Profil Mahasiswa</span>
                </a>
            </div>
        </div>

        <div class="rounded-xl border border-white/15 bg-white/10 p-5 backdrop-blur-xs">
            <div class="flex items-center justify-between border-b border-white/15 pb-3">
                <p class="text-xs font-bold uppercase tracking-widest text-amber-300">Data Akademik Mahasiswa</p>
                <span class="rounded bg-white/20 px-2 py-0.5 text-[10px] font-bold text-white uppercase tracking-wider">Aktif</span>
            </div>
            <dl class="mt-3.5 space-y-2 text-xs text-blue-50">
                <div class="flex justify-between py-1 border-b border-white/10">
                    <dt class="text-blue-200">Nama</dt>
                    <dd class="font-semibold">{{ $profil['nama'] }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-white/10">
                    <dt class="text-blue-200">NRP</dt>
                    <dd class="font-mono font-bold text-amber-200">{{ $profil['nrp'] }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-white/10">
                    <dt class="text-blue-200">Departemen</dt>
                    <dd class="font-semibold">{{ $profil['departemen'] }}</dd>
                </div>
                <div class="flex justify-between py-1">
                    <dt class="text-blue-200">Perguruan Tinggi</dt>
                    <dd class="font-semibold">Institut Teknologi Sepuluh Nopember</dd>
                </div>
            </dl>
            <div class="mt-4 border-t border-white/15 pt-3 flex items-center justify-between text-xs text-blue-200/90 font-mono">
                <span>Semester Gasal / PBKK</span>
                <span class="text-amber-300">Terverifikasi</span>
            </div>
        </div>
    </div>
</section>

<div class="mt-12 flex flex-wrap items-end justify-between gap-4">
    <div>
        <p class="eyebrow">Modul Aplikasi</p>
        <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Layanan & Fitur Portofolio</h2>
    </div>
    <a class="text-link" href="{{ route('profile') }}#tentang">Tentang aplikasi →</a>
</div>

<div class="mt-6 grid gap-5 md:grid-cols-3">
    <article class="feature-card border-t-3 border-t-[#013880] dark:border-t-sky-500">
        <p class="eyebrow">01 / Proyek AI</p>
        <h3 class="mt-3 text-lg font-bold text-slate-900 dark:text-white">Narafin AI Coach</h3>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $profil['ai']['capaian'] }}</p>
        <div class="mt-5 pt-3 border-t border-slate-100 dark:border-slate-800">
            <a class="text-link" href="{{ route('idea') }}#demo-saran">Coba demo →</a>
        </div>
    </article>

    <article class="feature-card border-t-3 border-t-[#f8ac18] dark:border-t-amber-400">
        <p class="eyebrow">02 / Akademik</p>
        <h3 class="mt-3 text-lg font-bold text-slate-900 dark:text-white">Profil & Kalkulator</h3>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 leading-relaxed">Riwayat belajar mahasiswa dan modul kalkulator IPK 2 semester berstandar ITS.</p>
        <div class="mt-5 pt-3 border-t border-slate-100 dark:border-slate-800">
            <a class="text-link" href="{{ route('calculator') }}#ipk">Hitung IPK →</a>
        </div>
    </article>

    <article class="feature-card border-t-3 border-t-[#001e3d] dark:border-t-sky-400">
        <p class="eyebrow">03 / Masukan</p>
        <h3 class="mt-3 text-lg font-bold text-slate-900 dark:text-white">Secure Feedback Hub</h3>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 leading-relaxed">Formulir evaluasi akademik terproteksi dengan validasi email ITS dan session CAPTCHA.</p>
        <div class="mt-5 pt-3 border-t border-slate-100 dark:border-slate-800">
            <a class="text-link" href="{{ route('feedback.create') }}">Tulis masukan →</a>
        </div>
    </article>
</div>

<section class="mt-10 rounded-xl border border-blue-200/90 bg-blue-50/60 p-6 dark:border-blue-900/60 dark:bg-blue-950/40">
    <p class="eyebrow">Rancangan Proyek Akhir</p>
    <h2 class="mt-1.5 text-xl font-bold text-slate-900 dark:text-white">Dari Analitika Angka Menjadi Keputusan Terstruktur</h2>
    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300 max-w-3xl">
        Instruktur menentukan sesi dan mode permainan, sistem memproses kalkulasi kas serta utilisasi bahan secara transparan, kemudian menyusun saran terarah bagi evaluasi performa pemain.
    </p>
    <div class="mt-4">
        <a class="text-link" href="{{ route('idea') }}#alur">Lihat alur rancangan →</a>
    </div>
</section>
@endsection

