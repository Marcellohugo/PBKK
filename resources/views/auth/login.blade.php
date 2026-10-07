@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="mx-auto max-w-md">
    <p class="eyebrow">Akun Narafin</p>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight">Masuk ke ruang kerja</h1>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Akses proyek dan analitika yang terhubung dengan akun Anda.</p>
    <form method="POST" action="{{ route('login') }}" class="feature-card mt-6 space-y-5 p-6">
        @csrf
        <div><label for="email" class="text-sm font-semibold">Email ITS</label><input id="email" class="field" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">@error('email')<p class="error">{{ $message }}</p>@enderror</div>
        <div><label for="password" class="text-sm font-semibold">Kata sandi</label><input id="password" class="field" type="password" name="password" required autocomplete="current-password">@error('password')<p class="error">{{ $message }}</p>@enderror</div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" class="accent-[#013880]"> Ingat saya</label>
        <button class="button w-full" type="submit">Masuk</button>
    </form>
    <p class="mt-5 text-center text-sm text-slate-600 dark:text-slate-300">Belum punya akun? <a class="text-link" href="{{ route('register') }}">Daftar sekarang</a></p>
</div>
@endsection
