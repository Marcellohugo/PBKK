<!doctype html>
<html lang="id" class="{{ ($dark ?? false) ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · ITS Academic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ ($dark ?? false) ? 'bg-slate-950 text-slate-100' : 'bg-slate-50 text-slate-900' }}">
<a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-3 focus:text-slate-900">Lewati navigasi</a>
<div class="border-b border-blue-950/20 bg-[#001e3d] py-1.5 text-xs text-slate-200 dark:border-slate-800 dark:bg-[#030911]">
    <div class="page flex flex-wrap items-center justify-between gap-2">
        <span class="font-medium tracking-wide">Institut Teknologi Sepuluh Nopember · Surabaya</span>
        <span class="hidden font-mono text-[11px] text-blue-200/90 sm:inline">FTEIC · Departemen Teknik Informatika</span>
    </div>
</div>
<header class="site-header sticky top-0 z-40">
    <nav class="page flex flex-wrap items-center justify-between gap-4 py-3" aria-label="Navigasi utama">
        <a class="site-brand" href="{{ route('home') }}">
            <span class="flex flex-col">
                <span class="flex items-center gap-1.5"><span class="text-xl font-black tracking-tight text-[#013880] dark:text-sky-400">ITS</span><span class="text-base font-bold tracking-tight text-slate-900 dark:text-white">Academic</span></span>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Portal riset · Teknik Informatika</span>
            </span>
        </a>
        <div class="site-nav">
            <a href="{{ route('home') }}" @if(request()->routeIs('home', 'beranda')) aria-current="page" @endif>Beranda</a>
            <a href="{{ route('profile') }}" @if(request()->routeIs('profile', 'profile.legacy', 'mahasiswa.show', 'about')) aria-current="page" @endif>Profil</a>
            <a href="{{ route('idea') }}" @if(request()->routeIs('idea', 'idea.store', 'research.plan', 'project', 'agent', 'dashboard.agent')) aria-current="page" @endif>ResearchMate</a>
            <a href="{{ route('calculator') }}" @if(request()->routeIs('calculator', 'calculate', 'ipk.*')) aria-current="page" @endif>Kalkulator</a>
            <a href="{{ route('feedback.create') }}" @if(request()->routeIs('feedback.*')) aria-current="page" @endif>Masukan</a>
            @auth
                <a href="{{ route('dashboard.home') }}" @if(request()->routeIs('dashboard.home', 'dashboard.project.show')) aria-current="page" @endif>Proyek saya</a>
            @endauth
            @auth
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="rounded-md px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">Keluar</button></form>
            @else
                <a href="{{ route('login') }}" @if(request()->routeIs('login', 'register')) aria-current="page" @endif>Masuk</a>
            @endauth
        </div>
    </nav>
</header>
<main id="konten" class="page min-h-[75vh] py-8 md:py-12">@yield('content')</main>
<footer class="border-t border-slate-200 bg-white py-7 text-sm dark:border-slate-800 dark:bg-slate-950">
    <div class="page flex flex-wrap items-center justify-between gap-4">
        <div><p class="font-bold">Teknik Informatika · Institut Teknologi Sepuluh Nopember</p><p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Kampus ITS Sukolilo, Surabaya 60111 · Layanan riset akademik</p></div>
        <p class="font-mono text-xs text-slate-500 dark:text-slate-400">ResearchMate AI</p>
    </div>
</footer>
</body>
</html>
