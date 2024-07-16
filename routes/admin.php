<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AssistantController;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'user-access:admin,assistant'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::middleware(['user-access:admin'])->group(function () {
        Route::resource('admins', AdminController::class)->parameters([
            'admins' => 'user'
        ]);
        Route::resource('assistants', AssistantController::class)->parameters([
            'assistants' => 'user'
        ]);
        Route::resource('students', StudentController::class)->parameters([
            'students' => 'user'
        ]);

    });
});

require __DIR__ . '/auth-admin.php';
