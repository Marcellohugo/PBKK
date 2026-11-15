<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1,api-login:')->name('api.login');

Route::middleware(['auth:sanctum', 'abilities:chat'])->group(function () {
    Route::delete('/token', [AuthController::class, 'destroy'])->name('api.token.destroy');
    Route::post('/chat-ai', [ChatController::class, 'store'])->middleware('throttle:10,1,chat:')->name('api.chat');
    Route::post('/chat-ai/stream', [ChatController::class, 'stream'])->middleware('throttle:10,1,chat:')->name('api.chat.stream');
});
