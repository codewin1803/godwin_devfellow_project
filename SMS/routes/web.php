<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SchoolAdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\BursarController;



Route::get('/', function () {
    return view('welcome');
});


Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
   
    
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])
        ->middleware('role:SuperAdmin')
        ->name('superadmin.dashboard');

    
    Route::get('/schooladmin/dashboard', [SchoolAdminController::class, 'dashboard'])
        ->middleware('role:SchoolAdmin')
        ->name('schooladmin.dashboard');

    // Teacher dashboard
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])
        ->middleware('role:Teacher')
        ->name('teacher.dashboard');

    // Student dashboard
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])
        ->middleware('role:Student')
        ->name('student.dashboard');


    Route::get('/parent/dashboard', [ParentController::class, 'dashboard'])
        ->middleware('role:Parent')
        ->name('parent.dashboard');


    Route::get('/bursar/dashboard', [BursarController::class, 'dashboard'])
        ->middleware('role:Bursar')
        ->name('bursar.dashboard');
});
