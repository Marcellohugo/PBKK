@props(['type' => 'info'])
@php
    $warna = [
        'success' => 'border-emerald-300 bg-emerald-50 text-emerald-950 dark:border-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-100',
        'error' => 'border-rose-300 bg-rose-50 text-rose-950 dark:border-rose-800 dark:bg-rose-950/60 dark:text-rose-100',
        'info' => 'border-blue-200 bg-blue-50 text-[#013880] dark:border-blue-900 dark:bg-[#0b1c33] dark:text-sky-200',
    ][$type] ?? 'border-slate-300 bg-slate-100 text-slate-900';
@endphp
<div {{ $attributes->class(['rounded-lg border p-4 text-sm font-medium', $warna]) }} role="{{ $type === 'error' ? 'alert' : 'status' }}">{{ $slot }}</div>

