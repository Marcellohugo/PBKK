<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/beranda', [PageController::class, 'index'])->name('beranda');
Route::get('/profil-mahasiswa', [PageController::class, 'profile'])->name('profile');
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
    Route::get('/', [PageController::class, 'index'])->name('home');
    Route::get('/mahasiswa/{nrp}', [PageController::class, 'student'])->where('nrp', '[0-9]{10}')->name('mahasiswa.show');
    Route::get('/agent/{tema?}', [PageController::class, 'agent'])->name('agent');
});
Route::get('/feedback', [PageController::class, 'feedbackCreate'])->name('feedback.create');
Route::post('/feedback', [PageController::class, 'feedbackStore'])->name('feedback.store');
Route::get('/feedback/sukses', [PageController::class, 'feedbackSuccess'])->name('feedback.success');
Route::fallback([PageController::class, 'notFound'])->name('not-found');
