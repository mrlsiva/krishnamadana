<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->group(function () {
    Route::view('/login', 'admin.auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['auth:admin'])->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    });
});
