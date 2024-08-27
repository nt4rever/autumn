<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\OAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'view'])->middleware('guest')->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::prefix('/oauth')->group(function () {
    Route::get('/login', [OAuthController::class, 'redirect']);
    Route::get('/callback', [OAuthController::class, 'callback']);
});
