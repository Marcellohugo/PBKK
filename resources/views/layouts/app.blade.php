<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · ITS Academic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<a class="skip-link" href="#konten">Lewati navigasi</a>
<nav class="navbar navbar-dark py-3" aria-label="Navigasi utama">
    <div class="container gap-3 flex-wrap">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}"><span class="brand-mark" aria-hidden="true">I</span>ITS <span class="fw-normal ms-1">Academic</span></a>
        <div class="nav-list">
            <a class="nav-link px-3 py-2" href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Beranda</a>
            <a class="nav-link px-3 py-2" href="{{ route('mahasiswa.show', config('profile.nrp')) }}" @if(request()->routeIs('mahasiswa.show')) aria-current="page" @endif>Profil</a>
            <a class="nav-link px-3 py-2" href="{{ route('dashboard.home') }}" @if(request()->routeIs('dashboard.*')) aria-current="page" @endif>Dashboard</a>
            <a class="nav-link px-3 py-2" href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif>Tentang</a>
            <a class="nav-link px-3 py-2" href="{{ route('project') }}" @if(request()->routeIs('project')) aria-current="page" @endif>Ide proyek</a>
            <a class="nav-link px-3 py-2" href="{{ route('agent') }}" @if(request()->routeIs('agent')) aria-current="page" @endif>Agent AI</a>
            <a class="nav-link px-3 py-2" href="{{ route('calculator') }}" @if(request()->routeIs('calculator', 'calculate')) aria-current="page" @endif>Kalkulator</a>
            <a class="nav-link px-3 py-2" href="{{ route('ipk.form') }}" @if(request()->routeIs('ipk.*')) aria-current="page" @endif>IPK</a>
            <a class="nav-link px-3 py-2" href="{{ route('feedback.create') }}" @if(request()->routeIs('feedback.*')) aria-current="page" @endif>Feedback</a>
        </div>
    </div>
</nav>
<main id="konten" class="container py-4 py-md-5">@yield('content')</main>
<footer class="container py-4 small muted d-flex flex-wrap justify-content-between gap-2"><span>Teknik Informatika · Institut Teknologi Sepuluh Nopember</span><span>Marco Marcello Hugo · 5025221102</span></footer>
</body>
</html>
