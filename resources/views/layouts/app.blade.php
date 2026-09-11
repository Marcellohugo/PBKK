<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · PBKK W2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<a class="skip-link" href="#konten">Lewati navigasi</a>
<nav class="navbar navbar-dark py-3" aria-label="Navigasi utama">
    <div class="container gap-3 flex-wrap">
        <a class="navbar-brand" href="{{ route('home') }}">ITS <span class="fw-normal">/ Academic</span></a>
        <div class="d-flex flex-wrap"><a class="nav-link px-2" href="{{ route('home') }}">Home</a>
<a class="nav-link px-2" href="{{ route('dashboard.home') }}">Dashboard</a>
<a class="nav-link px-2" href="{{ route('agent') }}">Agent AI</a>
<a class="nav-link px-2" href="{{ route('ipk.form') }}">Kalkulator IPK</a></div>
    </div>
</nav>
<main id="konten" class="container py-4 py-md-5">@yield('content')</main>
<footer class="container py-4 small muted">PBKK · Pertemuan 2 · Teknik Informatika ITS<br>Marco Marcello Hugo · 5025221102</footer>
</body>
</html>
