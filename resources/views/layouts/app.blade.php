<!doctype html>
<html lang="id" class="{{ ($dark ?? false) ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · Narafin AI Coach</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ ($dark ?? false) ? 'bg-slate-950 text-slate-100' : 'bg-slate-50 text-slate-900' }}">
<a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-3 focus:text-slate-900 focus:shadow-md">Lewati navigasi</a>

{{-- Product context bar --}}
<div class="border-b border-blue-950/20 bg-[#001e3d] text-slate-200 text-xs py-1.5 transition-colors dark:bg-[#030911] dark:border-slate-800">
    <div class="page flex flex-wrap items-center justify-between gap-2">
        <span class="font-medium tracking-wide">Narafin AI Coach</span>
        <span class="text-blue-200/90 font-mono text-[11px] hidden sm:inline">Analitika sesi Cashflowpoly</span>
    </div>
</div>

<header class="site-header sticky top-0 z-40">
    <nav class="page flex flex-wrap items-center justify-between gap-4 py-3" aria-label="Navigasi utama">
        <a class="site-brand" href="{{ route('home') }}">
            <div class="flex flex-col">
                <div class="flex items-center gap-1.5">
                    <span class="text-xl font-black tracking-tight text-[#013880] dark:text-sky-400">Narafin</span>
                    <span class="text-base font-bold tracking-tight text-slate-900 dark:text-white">AI Coach</span>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Keputusan berbasis metrik permainan</span>
            </div>
        </a>
        <div class="site-nav">
            <a href="{{ route('home') }}" @if(request()->routeIs('home', 'beranda')) aria-current="page" @endif>Beranda</a>
            <a href="{{ route('idea') }}" @if(request()->routeIs('idea', 'idea.store', 'player.advice', 'project', 'agent', 'dashboard.agent')) aria-current="page" @endif>Analitika</a>
            <a href="{{ route('feedback.create') }}" @if(request()->routeIs('feedback.*')) aria-current="page" @endif>Masukan</a>
            <a href="{{ route('about') }}" @if(request()->routeIs('profile', 'mahasiswa.show', 'dashboard.mahasiswa.show', 'about', 'calculator', 'calculate', 'ipk.*')) aria-current="page" @endif>Tentang</a>
            @auth
                <a href="{{ route('dashboard.home') }}" @if(request()->routeIs('dashboard.home')) aria-current="page" @endif>Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="rounded-md px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-[#013880] dark:text-slate-300 dark:hover:bg-slate-800">Keluar</button></form>
            @else
                <a href="{{ route('login') }}" @if(request()->routeIs('login', 'register')) aria-current="page" @endif>Masuk</a>
            @endauth
        </div>
    </nav>
</header>

<main id="konten" class="page min-h-[75vh] py-8 md:py-12">
    @yield('content')
</main>

<footer class="border-t border-slate-200/90 bg-white dark:bg-[#040a12] dark:border-slate-800/80 py-7 text-sm transition-colors">
    <div class="page flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="font-bold text-slate-800 dark:text-slate-200">Narafin AI Coach</p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Saran analitika permainan dari kas, bahan, dan pinjaman.</p>
        </div>
        <div class="text-right text-xs text-slate-600 dark:text-slate-400 font-mono">
            <span>© {{ date('Y') }} Narafin AI Coach</span>
        </div>
    </div>
</footer>
</body>
</html>
