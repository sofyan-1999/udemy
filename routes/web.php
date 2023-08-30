<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::post('courses/{course}', [AdminCourseController::class, 'updateCourse'])->name('courses.update.course');
        Route::resource('courses', AdminCourseController::class)->except(['update', 'show']);
    });

    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('courses/{course}/join', [StudentCourseController::class, 'joinCourse'])->name('courses.join');
        Route::resource('courses', StudentCourseController::class)->only(['index', 'show']);
    });
});
