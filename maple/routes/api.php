<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\OAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api,api-admin');

Route::prefix('/auth')->group(function () {
    Route::post('/login', [LoginController::class, 'apiLogin']);
    Route::post('/refresh', [OAuthController::class, 'refresh']);
    Route::post('/logout', [LogoutController::class, 'apiLogout'])->middleware('auth:api,api-admin');

    Route::prefix('/admin')->group(function () {
        Route::post('/login', [LoginController::class, 'apiAdminLogin']);
        Route::post('/refresh', [OAuthController::class, 'adminRefresh']);
    });
});
