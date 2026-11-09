@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="mx-auto max-w-md">
    <p class="eyebrow">Akun ResearchMate</p>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight">Masuk ke ruang kerja</h1>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Masuk untuk menyimpan rencana riset dan membuka proyek milik akun Anda.</p>
    <form method="POST" action="{{ route('login') }}" class="feature-card mt-6 space-y-5 p-6">
        @csrf
        <div><label for="email" class="text-sm font-semibold">Email</label><input id="email" class="field" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">@error('email')<p class="error">{{ $message }}</p>@enderror</div>
        <div><label for="password" class="text-sm font-semibold">Kata sandi</label><input id="password" class="field" type="password" name="password" required autocomplete="current-password">@error('password')<p class="error">{{ $message }}</p>@enderror</div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" class="accent-[#013880]"> Ingat saya</label>
        <button class="button w-full" type="submit">Masuk</button>
    </form>
    @if(app()->environment('local') && in_array(request()->ip(), ['127.0.0.1', '::1'], true))
        <div class="feature-card mt-4 p-6">
            <h2 class="text-sm font-bold">Akun demo lokal</h2>
            <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">Coba perbedaan akses Admin dan Staf pada dashboard.</p>
            <div class="mt-4 grid gap-2 sm:grid-cols-2">
                <form method="POST" action="{{ route('login.demo', ['role' => 'admin']) }}">@csrf<button class="button w-full" type="submit">Masuk sebagai Admin</button></form>
                <form method="POST" action="{{ route('login.demo', ['role' => 'staf']) }}">@csrf<button class="button-secondary w-full" type="submit">Masuk sebagai Staf</button></form>
            </div>
        </div>
    @endif
    <p class="mt-5 text-center text-sm text-slate-600 dark:text-slate-300">Belum punya akun? <a class="text-link" href="{{ route('register') }}">Daftar sekarang</a></p>
</div>
@endsection
