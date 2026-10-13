<!doctype html>
<html lang="id" class="{{ ($dark ?? false) ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · ResearchMate AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ ($dark ?? false) ? 'bg-slate-950 text-slate-100' : 'bg-slate-50 text-slate-900' }}">
<a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-3 focus:text-slate-900">Lewati navigasi</a>
<header class="site-header sticky top-0 z-40">
    <nav class="page flex flex-wrap items-center justify-between gap-4 py-3" aria-label="Navigasi utama">
        <a class="site-brand" href="{{ route('home') }}">
            <span class="grid h-9 w-9 place-items-center rounded-lg bg-blue-600 text-xl text-white" aria-hidden="true">✦</span>
            <span>Research<span class="text-blue-600 dark:text-blue-400">Mate</span><span class="ml-1 text-xs font-bold text-slate-500">AI</span></span>
        </a>
        <div class="site-nav">
            <a href="{{ route('home') }}" @if(request()->routeIs('home', 'beranda')) aria-current="page" @endif>Beranda</a>
            <a href="{{ route('idea') }}" @if(request()->routeIs('idea', 'idea.store', 'research.plan', 'project', 'agent', 'dashboard.agent')) aria-current="page" @endif>Rencana riset</a>
            @auth
                <a href="{{ route('dashboard.home') }}" @if(request()->routeIs('dashboard.home')) aria-current="page" @endif>Proyek saya</a>
            @endauth
            <a href="{{ route('feedback.create') }}" @if(request()->routeIs('feedback.*')) aria-current="page" @endif>Masukan</a>
            <a href="{{ route('about') }}" @if(request()->routeIs('about', 'profile', 'profile.legacy', 'mahasiswa.show', 'calculator', 'calculate', 'ipk.*')) aria-current="page" @endif>Tentang</a>
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
        <div><p class="font-bold">ResearchMate AI</p><p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Ruang kerja penelitian dengan bukti yang dapat diperiksa.</p></div>
        <p class="text-xs text-slate-500 dark:text-slate-400">Institut Teknologi Sepuluh Nopember · © {{ date('Y') }}</p>
    </div>
</footer>
</body>
</html>
