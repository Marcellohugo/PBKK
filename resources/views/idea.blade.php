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
            <h2 id="alur" class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Cara kerja analitika</h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Masukkan metrik sesi untuk melihat perhitungan dan saran yang dapat ditelusuri.</p>
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
        Konteks permainan: <a class="underline font-semibold text-[#013880] dark:text-sky-300" href="{{ $profil['ai']['sumber'] }}" target="_blank" rel="noopener">Narafin · Analitika Pemain, bagian Saran</a>. Hasil di halaman ini berbasis aturan; integrasi model bahasa masih dalam pengembangan.
    </p>
    <a class="text-link shrink-0" href="{{ route('agent') }}">Jelajahi skenario agent menurut mode →</a>
</div>

{{-- Contoh sesi untuk memahami indikator yang dipakai --}}
<section class="mt-12 rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33] sm:p-7" aria-labelledby="narafin-source-title">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200/80 pb-4 dark:border-slate-800">
        <div>
            <div class="badge-its mb-1">Contoh sesi</div>
            <h2 id="narafin-source-title" class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                Analitika Pemain pada Sesi · Narafin.org (Sesi #24)
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Ilustrasi metrik Cashflowpoly untuk menunjukkan cara membaca hasil analitika.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <span class="rounded-md bg-amber-50 px-3 py-1 text-xs font-bold text-amber-900 border border-amber-200/80 dark:bg-amber-950/40 dark:text-amber-200 dark:border-amber-800">
                Pemain: Marco · Sesi #24
            </span>
            <span class="rounded-md bg-blue-50 px-3 py-1 text-xs font-bold text-[#013880] border border-blue-200/80 dark:bg-blue-950/40 dark:text-sky-300 dark:border-blue-800">
                6 area analisis
            </span>
        </div>
    </div>

    {{-- Ringkasan 4 Indikator Agregat --}}
    <div class="mt-6">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-3">
            Ringkasan Indikator Kunci dari Sesi Permainan
        </p>
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border border-slate-200 bg-slate-50/70 p-3.5 dark:border-slate-800 dark:bg-slate-900/60">
                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase">Koin Tersisa</span>
                <p class="mt-1 text-2xl font-black text-slate-900 dark:text-white">15</p>
                <span class="text-[10px] text-rose-600 dark:text-rose-400 font-semibold">Perubahan -11.76% dari awal</span>
            </div>
            <div class="rounded-lg border border-slate-200 bg-slate-50/70 p-3.5 dark:border-slate-800 dark:bg-slate-900/60">
                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase">Poin Kebahagiaan</span>
                <p class="mt-1 text-2xl font-black text-rose-600 dark:text-rose-400">-21</p>
                <span class="text-[10px] text-slate-500 dark:text-slate-400">Total poin akhir terhambat</span>
            </div>
            <div class="rounded-lg border border-slate-200 bg-slate-50/70 p-3.5 dark:border-slate-800 dark:bg-slate-900/60">
                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase">Bahan Terpakai</span>
                <p class="mt-1 text-2xl font-black text-slate-900 dark:text-white">33.33%</p>
                <span class="text-[10px] text-amber-600 dark:text-amber-400 font-semibold">66.67% bahan menumpuk</span>
            </div>
            <div class="rounded-lg border border-slate-200 bg-slate-50/70 p-3.5 dark:border-slate-800 dark:bg-slate-900/60">
                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase">Status Pinjaman</span>
                <p class="mt-1 text-2xl font-black text-amber-600 dark:text-amber-400">1 Belum Lunas</p>
                <span class="text-[10px] text-slate-500 dark:text-slate-400">Beban penalti ganda di akhir</span>
            </div>
        </div>
    </div>

    {{-- Navigasi Pintas Antar 6 Bagian --}}
    <div class="mt-8 border-t border-slate-200/80 pt-6 dark:border-slate-800">
        <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
            <h3 class="text-sm font-bold tracking-tight text-slate-900 dark:text-white uppercase">
                Daftar 6 Area Analitika yang Ditangkap & Ditingkatkan AI
            </h3>
            <span class="text-xs text-slate-500 dark:text-slate-400">Klik tautan untuk lompat ke seksi</span>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="#narafin-sec-1" class="rounded-md border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-[#013880] hover:text-white hover:border-[#013880] transition-colors dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-300 dark:hover:bg-sky-600 dark:hover:text-white">
                01. Ringkasan & Prioritas
            </a>
            <a href="#narafin-sec-2" class="rounded-md border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-[#013880] hover:text-white hover:border-[#013880] transition-colors dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-300 dark:hover:bg-sky-600 dark:hover:text-white">
                02. Cerita di Balik Hasil
            </a>
            <a href="#narafin-sec-3" class="rounded-md border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-[#013880] hover:text-white hover:border-[#013880] transition-colors dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-300 dark:hover:bg-sky-600 dark:hover:text-white">
                03. Uang, Bahan & Usaha
            </a>
            <a href="#narafin-sec-4" class="rounded-md border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-[#013880] hover:text-white hover:border-[#013880] transition-colors dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-300 dark:hover:bg-sky-600 dark:hover:text-white">
                04. Pinjaman & Risiko
            </a>
            <a href="#narafin-sec-5" class="rounded-md border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-[#013880] hover:text-white hover:border-[#013880] transition-colors dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-300 dark:hover:bg-sky-600 dark:hover:text-white">
                05. Kebahagiaan & Well-Being
            </a>
            <a href="#narafin-sec-6" class="rounded-md border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-[#013880] hover:text-white hover:border-[#013880] transition-colors dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-300 dark:hover:bg-sky-600 dark:hover:text-white">
                06. Log Giliran & Data Lengkap
            </a>
        </div>
    </div>

    {{-- Daftar Komprehensif 6 Seksi --}}
    <div class="mt-8 space-y-10">

        {{-- SEKSI 1: Ringkasan & Prioritas Pembahasan --}}
        <article id="narafin-sec-1" class="scroll-mt-14 rounded-xl border border-slate-300/80 bg-slate-50/50 p-5 dark:border-slate-700/80 dark:bg-slate-900/40">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200/80 pb-3 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#013880] text-xs font-bold text-white dark:bg-sky-500">1</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">
                        Ringkasan Statistik Pemain & Prioritas Pembahasan
                    </h3>
                </div>
                <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400">narafin.org/sessions/10/players/4#summary</span>
            </div>

            <div class="mt-4 grid gap-6 lg:grid-cols-12 items-start">
                <div class="lg:col-span-6 space-y-2">
                    <div class="overflow-hidden rounded-lg border border-slate-300 bg-white shadow-xs dark:border-slate-700 dark:bg-slate-950">
                        <img src="{{ asset('images/narafin/1-ringkasan-prioritas.png') }}" 
                             alt="Tangkapan layar Ringkasan Statistik Pemain dan Prioritas Pembahasan di Narafin" 
                             class="w-full h-auto object-cover object-top"
                             loading="lazy">
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">
                        Tangkapan layar bagian atas: status <em>"Butuh tindakan segera"</em> dan prioritas pembahasan pinjaman belum lunas.
                    </p>
                </div>

                <div class="lg:col-span-6 space-y-4">
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-2xs dark:border-slate-800 dark:bg-[#071322]">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Indikator Riil pada Screenshot
                        </h4>
                        <ul class="mt-2 text-xs space-y-1.5 text-slate-700 dark:text-slate-300">
                            <li>• <strong>Kesimpulan Cepat:</strong> Status <span class="text-rose-600 dark:text-rose-400 font-bold">"Butuh tindakan segera"</span> (ada pinjaman aktif).</li>
                            <li>• <strong>Koin Tersisa:</strong> 15 (penurunan -11.76% dari saldo awal).</li>
                            <li>• <strong>Poin Kebahagiaan:</strong> -21 poin.</li>
                            <li>• <strong>Bahan Terpakai:</strong> 33.33% (dua pertiga stok bahan mengendap).</li>
                            <li>• <strong>Prioritas Pembahasan:</strong> Ditandai tag merah <span class="font-semibold text-rose-600 dark:text-rose-400">Pinjaman belum lunas</span>.</li>
                        </ul>
                    </div>

                    <div class="rounded-lg border border-rose-200 bg-rose-50/60 p-4 dark:border-rose-900/60 dark:bg-rose-950/25">
                        <h4 class="text-xs font-bold text-rose-950 dark:text-rose-200 flex items-center gap-1.5">
                            <span class="font-black text-rose-600 dark:text-rose-400">✕</span> Keterbatasan Sistem Narafin Saat Ini (Rule-Based)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-rose-900/90 dark:text-rose-200/90">
                            Narafin hanya mengevaluasi satu flag terisolasi: bila <code class="font-mono text-[11px]">sisa_pinjaman > 0</code>, munculkan status <em>"Butuh tindakan segera"</em>. Tidak ada penjelasan diagnostik mengapa pemain terpaksa meminjam dan apakah kondisi kas saat ini masih aman untuk dipulihkan.
                        </p>
                    </div>

                    <div class="rounded-lg border border-blue-200 bg-blue-50/60 p-4 dark:border-blue-900/60 dark:bg-blue-950/25">
                        <h4 class="text-xs font-bold text-[#013880] dark:text-sky-300 flex items-center gap-1.5">
                            <span class="font-black text-[#013880] dark:text-sky-300">✓</span> Peningkatan Fitur Agentic AI (Diagnostic Orchestrator)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-blue-950 dark:text-blue-100">
                            Agen AI mengintegrasikan seluruh sinyal: mendiagnosis bahwa pinjaman diambil karena pemain kehabisan kas setelah belanja bahan baku berlebih (78.57%), kemudian langsung merumuskan <strong>rekomendasi taktis pelunasan</strong> serta memproyeksikan skor akhir jika pinjaman tidak diselesaikan dalam 2 putaran ke depan.
                        </p>
                    </div>
                </div>
            </div>
        </article>

        {{-- SEKSI 2: Cerita di Balik Hasil Pemain --}}
        <article id="narafin-sec-2" class="scroll-mt-14 rounded-xl border border-slate-300/80 bg-slate-50/50 p-5 dark:border-slate-700/80 dark:bg-slate-900/40">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200/80 pb-3 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#013880] text-xs font-bold text-white dark:bg-sky-500">2</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">
                        Cerita di Balik Hasil Pemain (Causality & Narrative)
                    </h3>
                </div>
                <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400">narafin.org/sessions/10/players/4#story</span>
            </div>

            <div class="mt-4 grid gap-6 lg:grid-cols-12 items-start">
                <div class="lg:col-span-6 space-y-2">
                    <div class="overflow-hidden rounded-lg border border-slate-300 bg-white shadow-xs dark:border-slate-700 dark:bg-slate-950">
                        <img src="{{ asset('images/narafin/2-cerita-hasil.png') }}" 
                             alt="Tangkapan layar Cerita di Balik Hasil Pemain di Narafin" 
                             class="w-full h-auto object-cover object-top"
                             loading="lazy">
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">
                        Tangkapan layar seksi naratif Narafin: blok cerita terpisah untuk uang, risiko, dan kebahagiaan.
                    </p>
                </div>

                <div class="lg:col-span-6 space-y-4">
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-2xs dark:border-slate-800 dark:bg-[#071322]">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Indikator Riil pada Screenshot
                        </h4>
                        <ul class="mt-2 text-xs space-y-1.5 text-slate-700 dark:text-slate-300">
                            <li>• Narasi koin: Menjelaskan perubahan kas akhir dibandingkan awal secara nominal.</li>
                            <li>• Narasi usaha: Menyajikan perbandingan antara koin keluar belanja bahan vs pesanan jadi.</li>
                            <li>• Narasi risiko: Peringatan status pinjaman dalam sub-blok terpisah.</li>
                            <li>• Narasi kebahagiaan: Pengurangan poin kebahagiaan akibat beban tanggungan.</li>
                        </ul>
                    </div>

                    <div class="rounded-lg border border-rose-200 bg-rose-50/60 p-4 dark:border-rose-900/60 dark:bg-rose-950/25">
                        <h4 class="text-xs font-bold text-rose-950 dark:text-rose-200 flex items-center gap-1.5">
                            <span class="font-black text-rose-600 dark:text-rose-400">✕</span> Keterbatasan Sistem Narafin Saat Ini (Rule-Based)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-rose-900/90 dark:text-rose-200/90">
                            Teks disusun dari template string statis yang di-stitch per kondisi (contoh: <em>"Nilai negatif: koin berkurang"</em>). Kalimat-kalimat tersebut tidak memiliki jalinan sebab-akibat lintas waktu, sehingga instruktur tetap harus membaca semua kartu lalu merangkai sendiri jalan ceritanya.
                        </p>
                    </div>

                    <div class="rounded-lg border border-blue-200 bg-blue-50/60 p-4 dark:border-blue-900/60 dark:bg-blue-950/25">
                        <h4 class="text-xs font-bold text-[#013880] dark:text-sky-300 flex items-center gap-1.5">
                            <span class="font-black text-[#013880] dark:text-sky-300">✓</span> Peningkatan Fitur Agentic AI (Causal Narrative Synthesis Agent)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-blue-950 dark:text-blue-100">
                            AI menyusun <strong>alur kausalitas terpadu</strong>: <em>"Marco mengawali permainan dengan agresif memborong bahan mentah (78.57% kas), namun karena pesanan membutuhkan giliran tambahan, likuiditasnya macet. Saat tertimpa risiko, Marco terpaksa mengambil pinjaman darurat yang menghancurkan indeks kebahagiaannya (-21)."</em>
                        </p>
                    </div>
                </div>
            </div>
        </article>

        {{-- SEKSI 3: Uang, Bahan & Usaha --}}
        <article id="narafin-sec-3" class="scroll-mt-14 rounded-xl border border-slate-300/80 bg-slate-50/50 p-5 dark:border-slate-700/80 dark:bg-slate-900/40">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200/80 pb-3 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#013880] text-xs font-bold text-white dark:bg-sky-500">3</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">
                        Cerita Uang dan Usaha (Arus Koin & Efisiensi Bahan Baku)
                    </h3>
                </div>
                <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400">narafin.org/sessions/10/players/4#money-business</span>
            </div>

            <div class="mt-4 grid gap-6 lg:grid-cols-12 items-start">
                <div class="lg:col-span-6 space-y-2">
                    <div class="overflow-hidden rounded-lg border border-slate-300 bg-white shadow-xs dark:border-slate-700 dark:bg-slate-950">
                        <img src="{{ asset('images/narafin/3-uang-usaha.png') }}" 
                             alt="Tangkapan layar Cerita Uang dan Usaha di Narafin" 
                             class="w-full h-auto object-cover object-top"
                             loading="lazy">
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">
                        Tangkapan layar rincian arus kas: pengeluaran bahan 78.57%, utilisasi bahan 33.33%, dan margin untung pesanan 50%.
                    </p>
                </div>

                <div class="lg:col-span-6 space-y-4">
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-2xs dark:border-slate-800 dark:bg-[#071322]">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Indikator Riil pada Screenshot
                        </h4>
                        <ul class="mt-2 text-xs space-y-1.5 text-slate-700 dark:text-slate-300">
                            <li>• <strong>Pengeluaran Beli Bahan:</strong> <span class="font-bold text-amber-600 dark:text-amber-400">78.57%</span> dari seluruh koin keluar.</li>
                            <li>• <strong>Rasio Utilisasi Bahan:</strong> <span class="font-bold text-rose-600 dark:text-rose-400">33.33%</span> (sisa 66.67% menumpuk menganggur).</li>
                            <li>• <strong>Margin Keuntungan Pesanan:</strong> <span class="font-bold text-emerald-600 dark:text-emerald-400">50%</span> saat pesanan berhasil diselesaikan.</li>
                            <li>• <strong>Perubahan Kas:</strong> -11.76% (saldo koin akhir tersisa 15 koin).</li>
                        </ul>
                    </div>

                    <div class="rounded-lg border border-rose-200 bg-rose-50/60 p-4 dark:border-rose-900/60 dark:bg-rose-950/25">
                        <h4 class="text-xs font-bold text-rose-950 dark:text-rose-200 flex items-center gap-1.5">
                            <span class="font-black text-rose-600 dark:text-rose-400">✕</span> Keterbatasan Sistem Narafin Saat Ini (Rule-Based)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-rose-900/90 dark:text-rose-200/90">
                            Hanya menampilkan label statis <em>"Di bawah 60%: periksa bahan tersisa dan keuntungan pesanan"</em>. Sistem tidak menghitung batas toleransi modal kerja (working capital buffer) ataupun rekomendasi alokasi kas maksimal per giliran.
                        </p>
                    </div>

                    <div class="rounded-lg border border-blue-200 bg-blue-50/60 p-4 dark:border-blue-900/60 dark:bg-blue-950/25">
                        <h4 class="text-xs font-bold text-[#013880] dark:text-sky-300 flex items-center gap-1.5">
                            <span class="font-black text-[#013880] dark:text-sky-300">✓</span> Peningkatan Fitur Agentic AI (Working Capital & Inventory Agent)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-blue-950 dark:text-blue-100">
                            Agen AI mendeteksi sindrom <strong>Inventory Overstocking</strong>: memperingatkan pemain untuk menghentikan belanja bahan baru hingga utilisasi mencapai 75%, serta memberikan formula <em>safety stock</em> kas minimum 25% dari total aset agar tidak terjerat krisis likuiditas.
                        </p>
                    </div>
                </div>
            </div>
        </article>

        {{-- SEKSI 4: Pinjaman & Risiko --}}
        <article id="narafin-sec-4" class="scroll-mt-14 rounded-xl border border-slate-300/80 bg-slate-50/50 p-5 dark:border-slate-700/80 dark:bg-slate-900/40">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200/80 pb-3 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#013880] text-xs font-bold text-white dark:bg-sky-500">4</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">
                        Cerita Pinjaman dan Risiko (Status Utang & Beban Solvabilitas)
                    </h3>
                </div>
                <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400">narafin.org/sessions/10/players/4#loans-risk</span>
            </div>

            <div class="mt-4 grid gap-6 lg:grid-cols-12 items-start">
                <div class="lg:col-span-6 space-y-2">
                    <div class="overflow-hidden rounded-lg border border-slate-300 bg-white shadow-xs dark:border-slate-700 dark:bg-slate-950">
                        <img src="{{ asset('images/narafin/4-pinjaman-risiko.png') }}" 
                             alt="Tangkapan layar Cerita Pinjaman dan Risiko di Narafin" 
                             class="w-full h-auto object-cover object-top"
                             loading="lazy">
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">
                        Tangkapan layar seksi pinjaman dan risiko: status pinjaman aktif, beban bunga, dan risiko insolvensi akhir sesi.
                    </p>
                </div>

                <div class="lg:col-span-6 space-y-4">
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-2xs dark:border-slate-800 dark:bg-[#071322]">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Indikator Riil pada Screenshot
                        </h4>
                        <ul class="mt-2 text-xs space-y-1.5 text-slate-700 dark:text-slate-300">
                            <li>• <strong>Status Pinjaman:</strong> 1 pinjaman belum lunas saat permainan berakhir.</li>
                            <li>• <strong>Kategori Mode:</strong> Mode Mahir (di mana pinjaman aktif membawa beban bunga berkala).</li>
                            <li>• <strong>Dampak Akhir:</strong> Penalti poin kebahagiaan yang berat pada kalkulasi skor pemenang.</li>
                        </ul>
                    </div>

                    <div class="rounded-lg border border-rose-200 bg-rose-50/60 p-4 dark:border-rose-900/60 dark:bg-rose-950/25">
                        <h4 class="text-xs font-bold text-rose-950 dark:text-rose-200 flex items-center gap-1.5">
                            <span class="font-black text-rose-600 dark:text-rose-400">✕</span> Keterbatasan Sistem Narafin Saat Ini (Rule-Based)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-rose-900/90 dark:text-rose-200/90">
                            Sistem hanya memberi notifikasi pasif <em>"Masih ada pinjaman belum lunas"</em> tanpa menyediakan rencana aksi pemulihan (debt restructuring plan). Pemain tidak dibimbing kapan momen paling tepat melunasi pokok utang.
                        </p>
                    </div>

                    <div class="rounded-lg border border-blue-200 bg-blue-50/60 p-4 dark:border-blue-900/60 dark:bg-blue-950/25">
                        <h4 class="text-xs font-bold text-[#013880] dark:text-sky-300 flex items-center gap-1.5">
                            <span class="font-black text-[#013880] dark:text-sky-300">✓</span> Peningkatan Fitur Agentic AI (Debt Restructuring & Risk Mitigation Agent)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-blue-950 dark:text-blue-100">
                            Agen AI menyusun <strong>Debt Recovery Roadmap</strong>: mensimulasikan apakah pendapatan pesanan giliran berikutnya cukup untuk melunasi pinjaman sekaligus mempertahankan kelangsungan operasional tanpa harus berutang kembali.
                        </p>
                    </div>
                </div>
            </div>
        </article>

        {{-- SEKSI 5: Kebahagiaan & Well-Being --}}
        <article id="narafin-sec-5" class="scroll-mt-14 rounded-xl border border-slate-300/80 bg-slate-50/50 p-5 dark:border-slate-700/80 dark:bg-slate-900/40">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200/80 pb-3 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#013880] text-xs font-bold text-white dark:bg-sky-500">5</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">
                        Cerita Kebahagiaan dan Misi (Poin Kebahagiaan & Keseimbangan Hidup)
                    </h3>
                </div>
                <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400">narafin.org/sessions/10/players/4#happiness-mission</span>
            </div>

            <div class="mt-4 grid gap-6 lg:grid-cols-12 items-start">
                <div class="lg:col-span-6 space-y-2">
                    <div class="overflow-hidden rounded-lg border border-slate-300 bg-white shadow-xs dark:border-slate-700 dark:bg-slate-950">
                        <img src="{{ asset('images/narafin/5-kebahagiaan-misi.png') }}" 
                             alt="Tangkapan layar Cerita Kebahagiaan dan Misi di Narafin" 
                             class="w-full h-auto object-cover object-top"
                             loading="lazy">
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">
                        Tangkapan layar seksi kebahagiaan: skor negatif -21 poin akibat akumulasi denda, tekanan pinjaman, dan kegagalan kartu kebutuhan.
                    </p>
                </div>

                <div class="lg:col-span-6 space-y-4">
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-2xs dark:border-slate-800 dark:bg-[#071322]">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Indikator Riil pada Screenshot
                        </h4>
                        <ul class="mt-2 text-xs space-y-1.5 text-slate-700 dark:text-slate-300">
                            <li>• <strong>Total Poin Kebahagiaan:</strong> <span class="font-bold text-rose-600 dark:text-rose-400">-21 poin</span> (skor minus signifikan).</li>
                            <li>• <strong>Penyebab Penurunan:</strong> Tekanan tanggungan pinjaman, penalti giliran, dan minimnya pemenuhan kartu kebutuhan.</li>
                            <li>• <strong>Korelasi Finansial:</strong> Pemain terlalu fokus mengejar omzet pesanan tetapi mengabaikan well-being karakter.</li>
                        </ul>
                    </div>

                    <div class="rounded-lg border border-rose-200 bg-rose-50/60 p-4 dark:border-rose-900/60 dark:bg-rose-950/25">
                        <h4 class="text-xs font-bold text-rose-950 dark:text-rose-200 flex items-center gap-1.5">
                            <span class="font-black text-rose-600 dark:text-rose-400">✕</span> Keterbatasan Sistem Narafin Saat Ini (Rule-Based)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-rose-900/90 dark:text-rose-200/90">
                            Skor minus hanya diperlakukan sebagai angka agregat yang merugikan peringkat pemain. Tidak ada pesan edukatif yang mengajarkan bahwa dalam dunia nyata, bisnis tanpa keseimbangan hidup rentan memicu burnout dan kehancuran usaha.
                        </p>
                    </div>

                    <div class="rounded-lg border border-blue-200 bg-blue-50/60 p-4 dark:border-blue-900/60 dark:bg-blue-950/25">
                        <h4 class="text-xs font-bold text-[#013880] dark:text-sky-300 flex items-center gap-1.5">
                            <span class="font-black text-[#013880] dark:text-sky-300">✓</span> Peningkatan Fitur Agentic AI (Balanced Scorecard & Human-Centric Agent)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-blue-950 dark:text-blue-100">
                            Agen AI menyajikan refleksi <strong>Work-Life Balance</strong>: mengingatkan peserta bahwa efisiensi modal harus dibarengi investasi pada kartu kebahagiaan/kebutuhan hidup, memberikan wawasan kewirausahaan holistik berstandar kampus ITS.
                        </p>
                    </div>
                </div>
            </div>
        </article>

        {{-- SEKSI 6: Log Giliran & Data Lengkap --}}
        <article id="narafin-sec-6" class="scroll-mt-14 rounded-xl border border-slate-300/80 bg-slate-50/50 p-5 dark:border-slate-700/80 dark:bg-slate-900/40">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200/80 pb-3 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#013880] text-xs font-bold text-white dark:bg-sky-500">6</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">
                        Data Permainan Lengkap (Log Putaran, Transaksi & Aksi Granular)
                    </h3>
                </div>
                <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400">narafin.org/sessions/10/players/4#full-data</span>
            </div>

            <div class="mt-4 grid gap-6 lg:grid-cols-12 items-start">
                <div class="lg:col-span-6 space-y-2">
                    <div class="overflow-hidden rounded-lg border border-slate-300 bg-white shadow-xs dark:border-slate-700 dark:bg-slate-950">
                        <img src="{{ asset('images/narafin/6-log-permainan.png') }}" 
                             alt="Tangkapan layar Data Permainan Lengkap dan Log Putaran di Narafin" 
                             class="w-full h-auto object-cover object-top"
                             loading="lazy">
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">
                        Tangkapan layar tabel log giliran: riwayat rinci koin, dadu, kartu kesempatan, transaksi beli bahan, dan pemenuhan pesanan.
                    </p>
                </div>

                <div class="lg:col-span-6 space-y-4">
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-2xs dark:border-slate-800 dark:bg-[#071322]">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Indikator Riil pada Screenshot
                        </h4>
                        <ul class="mt-2 text-xs space-y-1.5 text-slate-700 dark:text-slate-300">
                            <li>• <strong>Rincian Per Ronde:</strong> Mencatat saldo awal giliran, lemparan dadu, dan kartu yang ditarik.</li>
                            <li>• <strong>Histori Transaksi:</strong> Alokasi koin keluar untuk bahan dan koin masuk dari pesanan.</li>
                            <li>• <strong>Kepadatan Data:</strong> Puluhan baris catatan log yang kompleks dalam format tabular.</li>
                        </ul>
                    </div>

                    <div class="rounded-lg border border-rose-200 bg-rose-50/60 p-4 dark:border-rose-900/60 dark:bg-rose-950/25">
                        <h4 class="text-xs font-bold text-rose-950 dark:text-rose-200 flex items-center gap-1.5">
                            <span class="font-black text-rose-600 dark:text-rose-400">✕</span> Keterbatasan Sistem Narafin Saat Ini (Rule-Based)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-rose-900/90 dark:text-rose-200/90">
                            Menyebabkan beban kognitif tinggi (<em>cognitive overload</em>) bagi dosen/fasilitator. Dalam kelas dengan 30+ mahasiswa, fasilitator tidak memiliki waktu untuk meneliti baris-demi-baris log untuk menemukan titik balik (<em>turning point</em>) kekeliruan keputusan peserta.
                        </p>
                    </div>

                    <div class="rounded-lg border border-blue-200 bg-blue-50/60 p-4 dark:border-blue-900/60 dark:bg-blue-950/25">
                        <h4 class="text-xs font-bold text-[#013880] dark:text-sky-300 flex items-center gap-1.5">
                            <span class="font-black text-[#013880] dark:text-sky-300">✓</span> Peningkatan Fitur Agentic AI (Facilitator Debriefing Generator)
                        </h4>
                        <p class="mt-1.5 text-xs leading-relaxed text-blue-950 dark:text-blue-100">
                            Agen AI memindai ribuan baris log dalam hitungan detik dan otomatis menghasilkan <strong>3 Pertanyaan Reflektif Fasilitator</strong> yang siap pakai, misalnya: <em>"Pada giliran ke-4, apa yang mendorong Anda memborong bahan padahal pesanan baru bisa diselesaikan 2 giliran berikutnya?"</em>.
                        </p>
                    </div>
                </div>
            </div>
        </article>

    </div>
</section>

<section id="demo-saran" class="mt-12 scroll-mt-10" aria-labelledby="demo-title">
    <div class="rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33] sm:p-7">
        <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-200/80 pb-5 dark:border-slate-800/80">
            <div>
                <div class="badge-its mb-1">Simulasi & Evaluasi Keputusan</div>
                <h2 id="demo-title" class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Simulator Analitika & Penyusunan Saran Pemain
                </h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400 max-w-2xl">
                    Uji logika pengambilan keputusan berbasis metrik permainan Cashflowpoly. Masukkan angka indikator secara manual atau pilih skenario preset cepat, lalu klik <strong>"Susun saran dari metrik"</strong> untuk memproses matriks evaluasi berbasis bukti angka.
                </p>
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

        {{-- Panduan Matriks Evaluasi & Logika Keputusan --}}
        <div class="mt-6 rounded-lg border border-blue-200/80 bg-blue-50/60 p-4 dark:border-blue-900/60 dark:bg-blue-950/30">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#013880] dark:text-sky-300 flex items-center gap-1.5">
                <span class="inline-flex h-4 w-4 items-center justify-center rounded-full bg-[#013880] text-[10px] text-white dark:bg-sky-500 font-bold">i</span>
                Bagaimana Matriks Evaluasi Bekerja Menyusun Saran?
            </h3>
            <p class="mt-1 text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                Algoritma analitika membandingkan 3 variabel finansial pemain terhadap ambang batas (<em>threshold</em>) objektif untuk menghasilkan diagnosa terarah:
            </p>
            <div class="mt-3 grid gap-3 sm:grid-cols-3 text-xs">
                <div class="rounded border border-blue-100 bg-white/80 p-3 dark:border-blue-900/50 dark:bg-slate-900/70">
                    <span class="font-bold text-[#013880] dark:text-sky-400">1. Matriks Arus Kas (&Delta;%)</span>
                    <p class="mt-1 text-[11px] text-slate-600 dark:text-slate-400">
                        Rumus: <code class="font-mono text-[10px]">((Akhir - Awal) / Awal) &times; 100%</code>. Jika bernilai negatif, algoritma mengeluarkan peringatan <em>Kas Menurun</em>.
                    </p>
                </div>
                <div class="rounded border border-blue-100 bg-white/80 p-3 dark:border-blue-900/50 dark:bg-slate-900/70">
                    <span class="font-bold text-[#013880] dark:text-sky-400">2. Matriks Utilisasi Bahan (%)</span>
                    <p class="mt-1 text-[11px] text-slate-600 dark:text-slate-400">
                        Rumus: <code class="font-mono text-[10px]">(Terpakai / Terkumpul) &times; 100%</code>. Ambang batas aman adalah &ge; 60%. Jika di bawah 60%, sinyal <em>Pemakaian Rendah</em> aktif.
                    </p>
                </div>
                <div class="rounded border border-blue-100 bg-white/80 p-3 dark:border-blue-900/50 dark:bg-slate-900/70">
                    <span class="font-bold text-[#013880] dark:text-sky-400">3. Matriks Liabilitas Utang</span>
                    <p class="mt-1 text-[11px] text-slate-600 dark:text-slate-400">
                        Khusus <strong>Mode Mahir</strong>: Jika sisa pinjaman &gt; 0, saran pinjaman otomatis diangkat menjadi <strong>Prioritas Utama #1</strong> sebelum saran kas dan bahan.
                    </p>
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

        {{-- Tombol Preset Skenario Cepat --}}
        <div class="mt-6 flex flex-wrap items-center gap-2">
            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Pilih Skenario Cepat:</span>
            <button type="button" 
                    onclick="setMetricPreset(17, 15, 6, 2, 1)" 
                    class="rounded-md border border-slate-300 bg-white px-3 py-1 text-xs font-semibold text-slate-700 hover:border-[#013880] hover:text-[#013880] transition dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                📋 Skenario 1: Kasus Riil Marco (Koin 15, Bahan 33%, Pinjaman 1)
            </button>
            <button type="button" 
                    onclick="setMetricPreset(15, 24, 10, 8, 0)" 
                    class="rounded-md border border-slate-300 bg-white px-3 py-1 text-xs font-semibold text-slate-700 hover:border-[#013880] hover:text-[#013880] transition dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                📋 Skenario 2: Usaha Sehat & Efisien (Koin +60%, Bahan 80%)
            </button>
            <button type="button" 
                    onclick="setMetricPreset(20, 12, 10, 4, 6)" 
                    class="rounded-md border border-slate-300 bg-white px-3 py-1 text-xs font-semibold text-slate-700 hover:border-[#013880] hover:text-[#013880] transition dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                📋 Skenario 3: Penumpukan Stok Mentah (-40%, Pinjaman 6)
            </button>
        </div>

        <form method="POST" action="{{ route('player.advice') }}" class="mt-3 grid gap-5 sm:grid-cols-2 rounded-lg bg-slate-50/70 p-5 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-800">
            @csrf
            <input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">
            <input type="hidden" name="mode_permainan" value="{{ $permainan }}">

            @foreach(['koin_awal' => ['Koin awal (saldo mulai)', 20, 1, 1000000], 'koin_akhir' => ['Koin akhir (saldo terkini)', 12, 0, 1000000], 'bahan_terkumpul' => ['Bahan terkumpul (total dibeli)', 10, 0, 100000], 'bahan_terpakai' => ['Bahan terpakai (jadikan pesanan)', 4, 0, 100000]] as $field => $spec)
            <div>
                <label for="{{ $field }}" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ $spec[0] }}</label>
                <input id="{{ $field }}" name="{{ $field }}" type="number" step="1" min="{{ $spec[2] }}" max="{{ $spec[3] }}" 
                       class="field text-sm" value="{{ old($field, $spec[1]) }}" aria-describedby="{{ $field }}-error" @if(str_starts_with($field, 'koin')) required @endif>
                @error($field)<p id="{{ $field }}-error" class="error">{{ $message }}</p>@enderror
            </div>
            @endforeach

            @if($permainan === 'mahir')
            <div class="sm:col-span-2">
                <label for="sisa_pinjaman" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Sisa pokok pinjaman (koin belum lunas)</label>
                <input id="sisa_pinjaman" name="sisa_pinjaman" type="number" min="0" max="1000000" step="1" 
                       class="field text-sm" value="{{ old('sisa_pinjaman', 6) }}" aria-describedby="sisa_pinjaman-error">
                @error('sisa_pinjaman')<p id="sisa_pinjaman-error" class="error">{{ $message }}</p>@enderror
            </div>
            @endif

            <div class="sm:col-span-2 pt-3 flex flex-wrap items-center justify-between gap-4 border-t border-slate-200/80 dark:border-slate-800">
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Kosongkan kedua kolom bahan jika belum tersedia. Sisa pinjaman 0 berarti lunas; kolom kosong berarti belum diketahui.
                </p>
                <button type="submit" class="button">
                    <span>Susun saran dari metrik</span>
                    <span aria-hidden="true">&rarr;</span>
                </button>
            </div>
        </form>

        <script>
            function setMetricPreset(awal, akhir, terkumpul, terpakai, pinjaman) {
                const elAwal = document.getElementById('koin_awal');
                const elAkhir = document.getElementById('koin_akhir');
                const elTerkumpul = document.getElementById('bahan_terkumpul');
                const elTerpakai = document.getElementById('bahan_terpakai');
                const elPinjaman = document.getElementById('sisa_pinjaman');

                if (elAwal) elAwal.value = awal;
                if (elAkhir) elAkhir.value = akhir;
                if (elTerkumpul) elTerkumpul.value = terkumpul;
                if (elTerpakai) elTerpakai.value = terpakai;
                if (elPinjaman) elPinjaman.value = pinjaman;
            }
        </script>

        @if(session('analitika'))
        <div id="hasil-saran" class="mt-8 border-t border-slate-200/80 pt-6 dark:border-slate-800" aria-live="polite">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <div class="badge-its mb-1">Hasil Analisis Terverifikasi</div>
                    <h3 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Hasil saran · {{ ucfirst(session('analitika.data.mode_permainan')) }}
                    </h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="rounded-md bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-800 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800">
                        Saran Dihitung Berbasis Bukti
                    </span>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                @foreach(session('analitika.saran') as $item)
                <x-info-card :title="$item['judul']" label="Saran berdasarkan input" 
                             class="{{ str_contains($item['judul'], 'Prioritas') ? 'border-amber-300 bg-amber-50/40 dark:border-amber-700 dark:bg-amber-950/20' : 'border-t-3 border-t-[#013880]' }}">
                    <div class="space-y-3">
                        <div class="rounded-md bg-slate-50 dark:bg-slate-800/80 p-3 border border-slate-200/80 dark:border-slate-700/80">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block mb-1">Bukti Kalkulasi Metrik:</span>
                            <p class="text-xs font-mono font-bold text-slate-900 dark:text-white">
                                {{ $item['bukti'] }}
                            </p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block mb-1">Rekomendasi Keputusan:</span>
                            <p class="text-sm leading-relaxed text-slate-700 dark:text-slate-300">{{ $item['isi'] }}</p>
                        </div>
                    </div>
                </x-info-card>
                @endforeach
            </div>
        </div>
        @else
        {{-- Panduan Status Sebelum Form Disubmit --}}
        <div class="mt-6 rounded-lg border border-dashed border-slate-300 p-4 text-center dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
            <p class="text-xs font-semibold text-slate-600 dark:text-slate-400">
                💡 <strong>Petunjuk:</strong> Klik salah satu tombol skenario cepat di atas atau masukkan angka metrik Anda sendiri, lalu tekan tombol <strong>"Susun saran dari metrik"</strong> untuk melihat hasil evaluasi matematis secara langsung.
            </p>
        </div>
        @endif
    </div>
</section>

<section id="kirim-ide" class="mt-12">
    <p class="eyebrow">Ide dari pengguna</p>
    <h2 class="mt-2 text-2xl font-bold">Kirim ide Agentic AI</h2>
    <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-300">Tuliskan ide pengembangan yang dapat ditinjau sebelum diimplementasikan.</p>
    @if(session('status'))
        <x-status-banner class="mt-5">{{ session('status') }} @if(session('ide')){{ session('ide.deskripsi') }}@endif</x-status-banner>
    @endif
    <form method="POST" action="{{ route('idea.store') }}" class="feature-card mt-5 grid gap-5 p-6 sm:grid-cols-2">
        @csrf
        <input type="hidden" name="mode" value="{{ $dark ? 'dark' : 'light' }}">
        <div><label for="ide-nama" class="text-sm font-semibold">Nama pengusul</label><input id="ide-nama" class="field" name="nama" value="{{ old('nama') }}" required minlength="3">@error('nama')<p class="error">{{ $message }}</p>@enderror</div>
        <div><label for="ide-judul" class="text-sm font-semibold">Judul ide</label><input id="ide-judul" class="field" name="judul" value="{{ old('judul') }}" required minlength="5">@error('judul')<p class="error">{{ $message }}</p>@enderror</div>
        <div class="sm:col-span-2"><label for="ide-deskripsi" class="text-sm font-semibold">Deskripsi ide</label><textarea id="ide-deskripsi" class="field min-h-32" name="deskripsi" required minlength="15">{{ old('deskripsi') }}</textarea>@error('deskripsi')<p class="error">{{ $message }}</p>@enderror</div>
        <div class="sm:col-span-2"><button type="submit" class="button">Kirim ide</button></div>
    </form>
</section>

@endsection


