<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\AssistantController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ClassModelController;
use App\Http\Controllers\Admin\AjaxDataTableController;

Route::middleware(['auth', 'user-access:admin,assistant'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::group(['prefix' => 'attendances', 'as' => 'attendances.'], function () {
        Route::get('/create/{schedule}', [AttendanceController::class, 'create'])->name('create');
    });

    Route::middleware(['user-access:admin'])->group(function () {
        Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::get('/create', [AdminController::class, 'create'])->name('create');
            Route::post('/', [AdminController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [AdminController::class, 'edit'])->name('edit');
            Route::patch('/{user}', [AdminController::class, 'update'])->name('update');
            Route::delete('/{user}', [AdminController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'assistants', 'as' => 'assistants.'], function () {
            Route::get('/', [AssistantController::class, 'index'])->name('index');
            Route::get('/create', [AssistantController::class, 'create'])->name('create');
            Route::post('/', [AssistantController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [AssistantController::class, 'edit'])->name('edit');
            Route::patch('/{user}', [AssistantController::class, 'update'])->name('update');
            Route::delete('/{user}', [AssistantController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'students', 'as' => 'students.'], function () {
            Route::get('/', [StudentController::class, 'index'])->name('index');
            Route::get('/end-year', [StudentController::class, 'endYear'])->name('end-year');
            Route::get('/create', [StudentController::class, 'create'])->name('create');
            Route::get('/{user}', [StudentController::class, 'show'])->name('show');
            Route::post('/', [StudentController::class, 'store'])->name('store');
            Route::post('/import', [StudentController::class, 'import'])->name('import');
            Route::get('/{user}/edit', [StudentController::class, 'edit'])->name('edit');
            Route::patch('/{user}', [StudentController::class, 'update'])->name('update');
            Route::delete('/{user}', [StudentController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'classes', 'as' => 'classes.'], function () {
            Route::get('/', [ClassModelController::class, 'index'])->name('index');
            Route::get('/create', [ClassModelController::class, 'create'])->name('create');
            Route::get('/{class}', [ClassModelController::class, 'show'])->name('show');
            Route::post('/', [ClassModelController::class, 'store'])->name('store');
            Route::get('/{class}/edit', [ClassModelController::class, 'edit'])->name('edit');
            Route::patch('/{class}', [ClassModelController::class, 'update'])->name('update');
            Route::delete('/{class}', [ClassModelController::class, 'destroy'])->name('destroy');

            Route::patch('/{class}/students/store', [ClassModelController::class, 'addStudents'])->name('students.store');
            Route::delete('/students/{user}/delete', [ClassModelController::class, 'deleteStudent'])->name('students.delete');
            Route::post('/{class}/subjects/store', [ClassModelController::class, 'addSubjects'])->name('subjects.store');
            Route::delete('/{class}/subjects/{subject}/delete', [ClassModelController::class, 'deleteSubject'])->name('subjects.delete');
        });

        Route::group(['prefix' => 'subjects', 'as' => 'subjects.'], function () {
            Route::get('/', [SubjectController::class, 'index'])->name('index');
            Route::get('/create', [SubjectController::class, 'create'])->name('create');
            Route::post('/', [SubjectController::class, 'store'])->name('store');
            Route::get('/{subject}/edit', [SubjectController::class, 'edit'])->name('edit');
            Route::patch('/{subject}', [SubjectController::class, 'update'])->name('update');
            Route::delete('/{subject}', [SubjectController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'schedules', 'as' => 'schedules.'], function () {
            Route::get('/', [ScheduleController::class, 'index'])->name('index');
            Route::get('/create', [ScheduleController::class, 'create'])->name('create');
            // Route::get('/{schedule}', [ScheduleController::class, 'show'])->name('show');
            Route::post('/', [ScheduleController::class, 'store'])->name('store');
            Route::get('/{schedule}/edit', [ScheduleController::class, 'edit'])->name('edit');
            Route::patch('/{schedule}/update-session', [ScheduleController::class, 'updateSession'])->name('update-session');
            Route::patch('/{schedule}/assistants/store', [ScheduleController::class, 'addAssistants'])->name('assistants.store');
            Route::delete('/{schedule}/assistants/{user}/delete', [ScheduleController::class, 'deleteAssistant'])->name('assistants.delete');
            Route::patch('/{schedule}', [ScheduleController::class, 'update'])->name('update');
            Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'attendances', 'as' => 'attendances.'], function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('index');
            Route::delete('/{attendance}', [AttendanceController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'data-table', 'as' => 'data-table.'], function () {
            Route::get("/class/{class}/students", [AjaxDataTableController::class, 'classStudents'])->name("class.students");
            Route::get("/class/{class}/subjects", [AjaxDataTableController::class, 'classSubjects'])->name("class.subjects");
        });

        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get("/", [SettingController::class, 'edit'])->name("edit");
            Route::patch("/", [SettingController::class, 'update'])->name("update");
        });


    });

    Route::group(['prefix' => 'schedules', 'as' => 'schedules.'], function () {
        Route::get('/{schedule}/end-session', [ScheduleController::class, 'endSession'])->name('end-session');
        Route::get('/{schedule}', [ScheduleController::class, 'show'])->name('show');
    });
});

require __DIR__ . '/auth-admin.php';
