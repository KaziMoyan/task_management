<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;





Route::resource('tasks', TaskController::class);

Route::get('/tasks/details/{id}', [TaskController::class, 'show'])->name('tasks.details');


Route::get('/tasks/{id}', [TaskController::class, 'show'])->middleware('auth');

Route::put('/tasks/{id}', [TaskController::class, 'updateTask'])->name('tasks.update');

Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my');

Route::get('/attendance', [AttendanceController::class, 'myAttendance'])->name('attendance.index');
Route::get('/attendance/export', [AttendanceController::class, 'exportMyAttendance'])->name('attendance.export');
Route::get('/attendance/filter', [AttendanceController::class, 'filterAttendance'])->name('attendance.filter');

Route::post('/attendance/export', [AttendanceController::class, 'exportMyAttendance'])->name('attendance.export');

//Route::post('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');

//Route::get('/attendance/export', [AttendanceController::class, 'exportMyAttendance'])->name('attendance.export');
//Route::get('/attendance/my', [AttendanceController::class, 'myAttendance'])->name('attendance.my');
//Route::get('/attendance/my/export', [AttendanceController::class, 'exportMyAttendance'])->name('attendance.my.export');
//Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');
//Route::post('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');


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


Route::middleware(['auth'])->group(function () {
    Route::get('/my-attendance', [AttendanceController::class, 'userAttendance'])->name('user.attendance');
    Route::get('/my-attendance/export', [AttendanceController::class, 'userAttendanceExport'])->name('user.attendance.export');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
