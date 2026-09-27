@extends('layouts.app')
@section('title', 'Masukan Berhasil')
@section('content')
<div class="mx-auto max-w-2xl">
    <div class="badge-its">
        Secure Feedback Hub
    </div>
    
    <div class="mt-4 rounded-lg border border-emerald-300 bg-emerald-50/90 p-5 text-emerald-950 shadow-2xs dark:border-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-100" role="status">
        <div class="flex items-center gap-3">
            <span class="grid h-8 w-8 place-items-center rounded-full bg-emerald-600 text-base font-bold text-white shadow-xs">✓</span>
            <div>
                <p class="text-base font-bold">Terima kasih, {{ $feedback['nama'] }}.</p>
                <p class="text-sm text-emerald-800 dark:text-emerald-200">Masukan berhasil divalidasi dan tersimpan di sesi Anda.</p>
            </div>
        </div>
    </div>

    <article class="mt-8 rounded-xl border border-slate-200/90 bg-white p-7 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33]">
        <div class="flex items-center justify-between border-b border-slate-200/70 pb-4 dark:border-slate-800/70">
            <div>
                <p class="eyebrow">{{ $feedback['kategori'] }}</p>
                <h1 class="mt-1 text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Konfirmasi masukan</h1>
            </div>
            <span class="rounded bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                Tervalidasi
            </span>
        </div>

        <div class="mt-6 space-y-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Email pengirim</p>
                <p class="mt-1 font-mono text-sm font-semibold text-slate-900 dark:text-white">{{ $feedback['email'] }}</p>
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pesan yang diajukan</p>
                <div class="mt-2 rounded-lg border border-slate-200/70 bg-slate-50/80 p-4 font-normal text-slate-800 dark:border-slate-800 dark:bg-slate-900/60 dark:text-slate-200">
                    <p class="whitespace-pre-wrap leading-relaxed">{{ $feedback['pesan'] }}</p>
                </div>
            </div>

            @if(!empty($feedback['mode_permainan']) && !empty($feedback['indikator']))
            <div class="rounded-lg border border-blue-200 bg-blue-50/60 p-3.5 text-xs text-[#013880] dark:border-blue-900 dark:bg-blue-950/40 dark:text-sky-200">
                <span class="font-bold">Konteks Narafin:</span> Mode {{ ucfirst($feedback['mode_permainan']) }} · {{ config('profile.ai.indikator.'.$feedback['indikator']) }}
            </div>
            @endif
        </div>

        <p class="mt-6 border-t border-slate-200/70 pt-4 text-xs text-slate-500 dark:border-slate-800/70 dark:text-slate-400">
            Konfirmasi ini hanya tersedia dalam sesi browser saat ini. Masukan belum disimpan atau dikirim ke departemen.
        </p>

        <div class="mt-6 flex flex-wrap gap-3">
            <a class="button" href="{{ route('feedback.create') }}">Tulis masukan baru</a>
            <a class="button-secondary" href="{{ route('home') }}">Kembali ke beranda</a>
        </div>
    </article>
</div>
@endsection

