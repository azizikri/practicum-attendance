<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AjaxDataTableController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AssistantController;
use App\Http\Controllers\Admin\ClassModelController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubjectController;

Route::middleware(['auth', 'user-access:admin,assistant'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::middleware(['user-access:admin'])->group(function () {
        Route::resource('admins', AdminController::class)->parameters([
            'admins' => 'user'
        ])->except(['show']);
        Route::resource('assistants', AssistantController::class)->parameters([
            'assistants' => 'user'
        ])->except(['show']);
        Route::resource('students', StudentController::class)->parameters([
            'students' => 'user'
        ])->except(['show']);

        Route::resource('classes', ClassModelController::class);
        Route::patch('/classes/{class}/students/store', [ClassModelController::class, 'addStudents'])->name('classes.students.store');
        Route::delete('/classes/students/{user}/delete', [ClassModelController::class, 'deleteStudent'])->name('classes.students.delete');
        Route::post('/classes/{class}/subjects/store', [ClassModelController::class, 'addSubjects'])->name('classes.subjects.store');
        Route::delete('/classes/{class}/subjects/{subject}/delete', [ClassModelController::class, 'deleteSubject'])->name('classes.subjects.delete');

        Route::resource('subjects', SubjectController::class)->except(['show']);


        Route::get("/data-table/class/{class}/students", [AjaxDataTableController::class, 'classStudents'])->name("data-table.class.students");
        Route::get("/data-table/class/{class}/subjects", [AjaxDataTableController::class, 'classSubjects'])->name("data-table.class.subjects");
    });
});

require __DIR__ . '/auth-admin.php';
