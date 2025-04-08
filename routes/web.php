<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('tasks', TaskController::class);
});

Route::resource('tasks', TaskController::class);

Route::post('/attendance-toggle', [AttendanceController::class, 'toggle'])->name('attendance.toggle');

Route::middleware(['auth'])->group(function () {
    Route::get('/attend/create', [AttendanceController::class, 'create'])->name('attend.create');
    Route::post('/attend/store', [AttendanceController::class, 'store'])->name('attend.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
