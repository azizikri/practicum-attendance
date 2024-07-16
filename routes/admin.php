<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'user-access:admin,assistant'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::middleware(['user-access:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('admins', AdminController::class);
    });
});

require __DIR__ . '/auth-admin.php';
