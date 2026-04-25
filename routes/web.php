<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupervisorController;


//WELCOME PAGE

Route::get('/', function () {
    return view('welcome');
});


//AUTH (Coordinator + Supervisor)

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('auth.showLogin');

Route::post('/login', [AuthController::class, 'login'])
    ->name('auth.login');


//STUDENT AUTH (SEPARATE)

Route::get('/student/login', [AuthController::class, 'showStudentLogin'])
    ->name('auth.showStudentLogin');

Route::post('/student/login', [AuthController::class, 'studentLogin'])
    ->name('auth.studentLogin');


//PROTECTED ROUTES (AUTH REQUIRED)

Route::middleware(['auth'])->group(function () {

    //SUPERVISOR 

    // Dashboard
    Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard'])
        ->name('supervisor.dashboard');

    // Students list
    Route::get('/supervisor/students', [SupervisorController::class, 'students'])
        ->name('supervisor.students');

    // Titles page (Approve / Reject)
    Route::get('/supervisor/titles', [SupervisorController::class, 'titles'])
        ->name('supervisor.titles');

    // View single student
    Route::get('/supervisor/student/{id}', [SupervisorController::class, 'viewStudent'])
        ->name('supervisor.viewStudent');

    // Approve / Reject title
    Route::post('/supervisor/approve-title/{id}', [SupervisorController::class, 'approveTitle'])
        ->name('supervisor.approveTitle');

    Route::post('/supervisor/reject-title/{id}', [SupervisorController::class, 'rejectTitle'])
        ->name('supervisor.rejectTitle');


     //COORDINATOR 

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

    //STUDENT

    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])
        ->name('student.dashboard');

    Route::post('/student/title', [StudentController::class, 'submitTitle'])
        ->name('student.submitTitle');


    //LOGOUT 

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('auth.logout');
});


//PASSWORD CHANGE

Route::get('/change-password', [AuthController::class, 'showChangePassword'])
    ->name('auth.showChangePassword');

Route::post('/change-password', [AuthController::class, 'updatePassword'])
    ->name('auth.updatePassword');




