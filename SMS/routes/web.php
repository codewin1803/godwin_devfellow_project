<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Default Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes (Login, Register, Logout, etc.)
Auth::routes();

// Dashboard — accessible by any logged-in user
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');

// SuperAdmin Only
Route::middleware(['role:SuperAdmin'])->group(function () {
    Route::get('/superadmin/dashboard', function () {
        return view('roles.superadmin');
    })->name('superadmin.dashboard');
});
Route::middleware(['role:SuperAdmin'])->group(function () {
    Route::resource('schools', App\Http\Controllers\SchoolController::class);
});


//SchoolAdmin Only
Route::middleware(['role:SchoolAdmin'])->group(function () {
    Route::get('/schooladmin/dashboard', function () {
        return view('roles.schooladmin');
    })->name('schooladmin.dashboard');
});

// Teacher Only
Route::middleware(['role:Teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('roles.teacher');
    })->name('teacher.dashboard');
});

// Student Only
Route::middleware(['role:Student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('roles.student');
    })->name('student.dashboard');
});

// Parent Only
Route::middleware(['role:Parent'])->group(function () {
    Route::get('/parent/dashboard', function () {
        return view('roles.parent');
    })->name('parent.dashboard');
});

// Bursar Only
Route::middleware(['role:Bursar'])->group(function () {
    Route::get('/bursar/dashboard', function () {
        return view('roles.bursar');
    })->name('bursar.dashboard');
});
