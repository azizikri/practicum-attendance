<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsChangePassword;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'user-access:student', 'is-change-password'])->group(function () {

    Route::get('/scan-qr', function () {
        return view('scan-qr');
    })->middleware(['auth', 'verified'])->name('scan-qr');

    Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->withoutMiddleware([IsChangePassword::class]);

    Route::group(['prefix' => 'attendances', 'as' => 'attendances.'], function(){
        Route::get('/mark/{token}/{assistant}/{schedule}', [AttendanceController::class, 'store'])->name('store');
    });
});
require __DIR__ . '/auth.php';
