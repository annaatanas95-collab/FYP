<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupervisorController;

// AUTH (SHARED LOGIN FOR COORDINATOR + SUPERVISOR)


Route::get('/register',[AuthController::class,'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// SUPERVISOR ROUTES (NEW)


Route::middleware(['auth'])->group(function () {

    Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard'])
        ->name('supervisor.dashboard');

});

// COORDINATOR ROUTES


Route::middleware(['auth'])->group(function () {

    Route::get('/coordinator/dashboard', [CoordinatorController::class, 'dashboard'])
        ->name('coordinator.dashboard');

    Route::post('/coordinator/upload-students', [CoordinatorController::class, 'uploadStudents']);

    Route::post('/coordinator/delete-uploaded-students', [CoordinatorController::class, 'deleteUploadedStudents']);

    // Supervisor management
    Route::get('/coordinator/register-supervisor', [CoordinatorController::class, 'showRegisterSupervisor'])
        ->name('coordinator.showRegisterSupervisor');

    Route::post('/coordinator/register-supervisor', [CoordinatorController::class, 'registerSupervisor'])
        ->name('coordinator.registerSupervisor');

    Route::get('/coordinator/supervisors', [CoordinatorController::class, 'showSupervisors'])
        ->name('coordinator.supervisors');

    Route::post('/coordinator/update-supervisor', [CoordinatorController::class, 'updateSupervisor'])
        ->name('coordinator.supervisor.update');

    Route::post('/coordinator/delete-supervisor/{id}', [CoordinatorController::class, 'deleteSupervisor'])
        ->name('coordinator.supervisor.delete');
});

// STUDENT ROUTES (UNCHANGED - KEEP YOUR SYSTEM)


Route::get('/student/login', [AuthController::class, 'showStudentLogin'])
    ->name('auth.showStudentLogin');

Route::post('/student/login', [AuthController::class, 'studentLogin'])
    ->name('auth.studentLogin');

Route::middleware(['auth'])->group(function () {

    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])
        ->name('student.dashboard');

});

// PASSWORD RESET


Route::get('/change-password', [AuthController::class, 'showChangePassword'])
    ->name('auth.showChangePassword');

Route::post('/change-password', [AuthController::class, 'updatePassword'])
    ->name('auth.updatePassword');

// LOGOUT

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('auth.logout');





