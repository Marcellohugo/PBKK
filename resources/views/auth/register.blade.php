@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="mx-auto max-w-md">
    <p class="eyebrow">Akun mahasiswa</p>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight">Buat akun portofolio</h1>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Gunakan alamat @student.its.ac.id untuk menyimpan identitas akun.</p>
    <form method="POST" action="{{ route('register') }}" class="feature-card mt-6 space-y-5 p-6">
        @csrf
        <div><label for="name" class="text-sm font-semibold">Nama lengkap</label><input id="name" class="field" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">@error('name')<p class="error">{{ $message }}</p>@enderror</div>
        <div><label for="email" class="text-sm font-semibold">Email mahasiswa ITS</label><input id="email" class="field" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">@error('email')<p class="error">{{ $message }}</p>@enderror</div>
        <div><label for="password" class="text-sm font-semibold">Kata sandi</label><input id="password" class="field" type="password" name="password" required autocomplete="new-password">@error('password')<p class="error">{{ $message }}</p>@enderror</div>
        <div><label for="password_confirmation" class="text-sm font-semibold">Ulangi kata sandi</label><input id="password_confirmation" class="field" type="password" name="password_confirmation" required autocomplete="new-password"></div>
        <button class="button w-full" type="submit">Daftar</button>
    </form>
    <p class="mt-5 text-center text-sm text-slate-600 dark:text-slate-300">Sudah punya akun? <a class="text-link" href="{{ route('login') }}">Masuk</a></p>
</div>
@endsection
