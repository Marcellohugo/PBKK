<!doctype html>
<html lang="id" class="{{ ($dark ?? false) ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · ITS Academic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ ($dark ?? false) ? 'bg-slate-950 text-slate-100' : 'bg-slate-50 text-slate-900' }}">
<a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-3 focus:text-slate-900 focus:shadow-md">Lewati navigasi</a>

{{-- Top Institutional Bar khas ITS --}}
<div class="border-b border-blue-950/20 bg-[#001e3d] text-slate-200 text-xs py-1.5 transition-colors dark:bg-[#030911] dark:border-slate-800">
    <div class="page flex flex-wrap items-center justify-between gap-2">
        <span class="font-medium tracking-wide">Institut Teknologi Sepuluh Nopember · Surabaya</span>
        <div class="flex items-center gap-2 font-mono text-[11px]">
            <span class="text-blue-200/90 hidden sm:inline">FTEIC · Teknik Informatika</span>
            <span class="rounded bg-white/10 px-2 py-0.5 text-[10px] font-bold text-amber-300 border border-white/15">Progres Kurikulum: w1 &rarr; w4</span>
        </div>
    </div>
</div>

<header class="site-header sticky top-0 z-40">
    <nav class="page flex flex-wrap items-center justify-between gap-4 py-3" aria-label="Navigasi utama">
        <a class="site-brand" href="{{ route('home') }}">
            <div class="flex flex-col">
                <div class="flex items-center gap-1.5">
                    <span class="text-xl font-black tracking-tight text-[#013880] dark:text-sky-400">ITS</span>
                    <span class="text-base font-bold tracking-tight text-slate-900 dark:text-white">Academic</span>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Portal PBKK · Teknik Informatika</span>
            </div>
        </a>
        <div class="site-nav">
            <a href="{{ route('home') }}" @if(request()->routeIs('home', 'beranda', 'dashboard.home')) aria-current="page" @endif>Beranda</a>
            <a href="{{ route('profile') }}" @if(request()->routeIs('profile', 'mahasiswa.show', 'dashboard.mahasiswa.show', 'about')) aria-current="page" @endif>Profil</a>
            <a href="{{ route('idea') }}" @if(request()->routeIs('idea', 'idea.store', 'player.advice', 'project', 'agent', 'dashboard.agent')) aria-current="page" @endif>Ide Agentic AI</a>
            <a href="{{ route('calculator') }}" @if(request()->routeIs('calculator', 'calculate', 'ipk.*')) aria-current="page" @endif>Kalkulator</a>
            <a href="{{ route('feedback.create') }}" @if(request()->routeIs('feedback.*')) aria-current="page" @endif>Feedback</a>
        </div>
    </nav>
</header>

<main id="konten" class="page min-h-[75vh] py-8 md:py-12">
    @yield('content')
</main>

<footer class="border-t border-slate-200/90 bg-white dark:bg-[#040a12] dark:border-slate-800/80 py-7 text-sm transition-colors">
    <div class="page flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="font-bold text-slate-800 dark:text-slate-200">Teknik Informatika · Institut Teknologi Sepuluh Nopember</p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kampus ITS Sukolilo, Surabaya 60111 · Pemrograman Berbasis Kerangka Kerja</p>
        </div>
        <div class="text-right text-xs text-slate-600 dark:text-slate-400 font-mono">
            <span>Marco Marcello Hugo · 5025221102</span>
        </div>
    </div>
</footer>
</body>
</html>
