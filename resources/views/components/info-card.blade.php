@props(['title', 'label' => null])
<article {{ $attributes->class(['rounded-xl border border-slate-200/90 bg-white p-6 shadow-2xs dark:border-slate-800 dark:bg-[#0b1c33]']) }}>
    @if($label)<p class="eyebrow mb-2">{{ $label }}</p>@endif
    <h2 class="mb-3 text-lg font-bold text-slate-900 dark:text-white">{{ $title }}</h2>
    <div class="leading-relaxed text-slate-600 dark:text-slate-300 text-sm">{{ $slot }}</div>
</article>

