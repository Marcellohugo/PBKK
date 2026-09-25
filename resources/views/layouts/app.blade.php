<!doctype html>
<html lang="id" class="{{ ($dark ?? false) ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · ITS Academic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ ($dark ?? false) ? 'bg-slate-950 text-slate-100' : 'bg-slate-50 text-slate-900' }}">
<a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:bg-white focus:p-4 focus:text-slate-900">Lewati navigasi</a>
<header class="site-header">
    <nav class="page py-5" aria-label="Navigasi utama">
        <div class="flex flex-wrap items-center justify-between gap-3"><a class="site-brand" href="{{ route('home') }}"><span class="brand-mark" aria-hidden="true">I</span><span>ITS <span class="font-normal text-slate-500 dark:text-slate-400">Academic</span></span></a><span class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">Student workspace</span></div>
        <div class="site-nav mt-5"><a href="{{ route('home') }}" @if(request()->routeIs('home', 'beranda')) aria-current="page" @endif>Beranda</a><a href="{{ route('profile') }}" @if(request()->routeIs('profile', 'mahasiswa.show')) aria-current="page" @endif>Profil</a><a href="{{ route('dashboard.home') }}" @if(request()->routeIs('dashboard.*')) aria-current="page" @endif>Dashboard</a><a href="{{ route('idea') }}" @if(request()->routeIs('idea', 'idea.store', 'player.advice')) aria-current="page" @endif>Ide Agentic AI</a><a href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif>Tentang</a><a href="{{ route('agent') }}" @if(request()->routeIs('agent')) aria-current="page" @endif>Agent</a><a href="{{ route('calculator') }}" @if(request()->routeIs('calculator', 'calculate')) aria-current="page" @endif>Kalkulator</a><a href="{{ route('ipk.form') }}" @if(request()->routeIs('ipk.*')) aria-current="page" @endif>IPK</a><a href="{{ route('feedback.create') }}" @if(request()->routeIs('feedback.*')) aria-current="page" @endif>Feedback</a></div>
    </nav>
</header>
<main id="konten" class="page min-h-[75vh] py-10 md:py-14">@yield('content')</main>
<footer class="page flex flex-wrap justify-between gap-3 border-t border-slate-200 py-6 text-sm text-slate-600 dark:border-slate-800 dark:text-slate-400"><span>Teknik Informatika · Institut Teknologi Sepuluh Nopember</span><span>Marco Marcello Hugo · 5025221102</span></footer>
</body>
</html>
