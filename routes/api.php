<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::get('unauthenticated', 'unauthenticated')->name('login');
    Route::post('login', 'login')->name('auth.login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'logout')->name('auth.logout');
        Route::get('profile', 'profile')->name('auth.profile');
    });
});
