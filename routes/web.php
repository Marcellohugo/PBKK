<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/project-idea', [PageController::class, 'project'])->name('project');
Route::get('/kalkulator', [PageController::class, 'calculator'])->name('calculator');
Route::get('/hitung/{angka1}/{angka2}/{operasi}', [PageController::class, 'calculate'])->name('calculate');
