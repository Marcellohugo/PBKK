<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [PageController::class, 'store'])->name('feedback.store');
Route::get('/feedback/sukses', [PageController::class, 'success'])->name('feedback.success');
