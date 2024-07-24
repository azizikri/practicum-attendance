<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Middleware\IsChangePassword;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'user-access:student', 'is-change-password'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->withoutMiddleware([IsChangePassword::class]);

    Route::group(['prefix' => 'attendances', 'as' => 'attendances.'], function(){
        Route::get('/mark/{token}/{assistant}/{schedule}', [AttendanceController::class, 'store'])->name('store');
    });
});
require __DIR__ . '/auth.php';
