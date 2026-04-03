<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\StudentController;

Route::get('/register',[AuthController::class,'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Coordinator routes
Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/dashboard', [CoordinatorController::class, 'dashboard'])->name('coordinator.dashboard');
    Route::post('/coordinator/upload-students', [CoordinatorController::class, 'uploadStudents']);

});
Route::post('/coordinator/delete-uploaded-students', [CoordinatorController::class, 'deleteUploadedStudents'])->middleware('auth');

// Student login
Route::get('/student/login', [AuthController::class, 'showStudentLogin'])->name('auth.showStudentLogin');
Route::post('/student/login', [AuthController::class, 'studentLogin'])->name('auth.studentLogin');

Route::middleware(['auth'])->group(function() {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
});

// Change password (for students)
Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('auth.showChangePassword');
Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('auth.updatePassword');

// Logout (all users)
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');





