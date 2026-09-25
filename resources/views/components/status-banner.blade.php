@props(['type' => 'info'])
@php
    $warna = [
        'success' => 'border-emerald-300 bg-emerald-50 text-emerald-900 dark:border-emerald-700 dark:bg-emerald-950 dark:text-emerald-100',
        'error' => 'border-red-300 bg-red-50 text-red-900 dark:border-red-700 dark:bg-red-950 dark:text-red-100',
        'info' => 'border-sky-200 bg-sky-50 text-sky-900 dark:border-sky-700 dark:bg-sky-950 dark:text-sky-100',
    ][$type] ?? 'border-slate-300 bg-slate-100 text-slate-900';
@endphp
<div {{ $attributes->class(['rounded-xl border p-4', $warna]) }} role="{{ $type === 'error' ? 'alert' : 'status' }}">{{ $slot }}</div>
