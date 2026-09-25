@props(['title', 'label' => null])
<article {{ $attributes->class(['rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900']) }}>
    @if($label)<p class="eyebrow mb-3">{{ $label }}</p>@endif
    <h2 class="mb-3 text-xl font-bold">{{ $title }}</h2>
    <div class="leading-relaxed text-slate-600 dark:text-slate-300">{{ $slot }}</div>
</article>
