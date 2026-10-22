<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// after login, go straight to the students page
Route::get('/dashboard', function () {
    return redirect()->route('students.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // only logged-in users can use these pages
    Route::resource('students', StudentController::class)->except('show');
    Route::resource('subjects', SubjectController::class)->except('show');

    Route::get('attendances/report', [AttendanceController::class, 'report'])->name('attendances.report');
    Route::resource('attendances', AttendanceController::class)->only(['index', 'create', 'store', 'destroy']);
});

require __DIR__.'/auth.php';