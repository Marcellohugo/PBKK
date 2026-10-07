<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/beranda', [PageController::class, 'index'])->name('beranda');
Route::get('/pengembang', [PageController::class, 'profile'])->name('profile');
Route::get('/profil-mahasiswa', [PageController::class, 'profile'])->name('profile.legacy');
Route::get('/ide-agent', [PageController::class, 'idea'])->name('idea');
Route::post('/ide-agent', [PageController::class, 'store'])->name('idea.store');
Route::post('/saran-pemain', [PageController::class, 'recommendations'])->name('player.advice');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/project-idea', [PageController::class, 'project'])->name('project');
Route::get('/kalkulator', [PageController::class, 'calculator'])->name('calculator');
Route::get('/hitung/{angka1}/{angka2}/{operasi}', [PageController::class, 'calculate'])->name('calculate');
Route::get('/mahasiswa/{nrp}', [PageController::class, 'student'])->where('nrp', '[0-9]{10}')->name('mahasiswa.show');
Route::get('/agent/{tema?}', [PageController::class, 'agent'])->name('agent');
Route::get('/ipk', [PageController::class, 'ipkForm'])->name('ipk.form');
Route::get('/hitung-ipk/{ip1}/{ip2}', [PageController::class, 'ipk'])->name('ipk.calculate');
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('home');
    Route::get('/mahasiswa/{nrp}', [PageController::class, 'student'])->where('nrp', '[0-9]{10}')->name('mahasiswa.show');
    Route::get('/agent/{tema?}', [PageController::class, 'agent'])->name('agent');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/feedback', [PageController::class, 'feedbackCreate'])->name('feedback.create');
Route::post('/feedback', [PageController::class, 'feedbackStore'])->name('feedback.store');
Route::get('/feedback/sukses', [PageController::class, 'feedbackSuccess'])->name('feedback.success');
Route::fallback([PageController::class, 'notFound'])->name('not-found');
