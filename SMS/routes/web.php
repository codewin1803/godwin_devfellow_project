<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Controller Imports
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\ParentProfileController;
use App\Http\Controllers\ClassroomAssignmentController;
use App\Http\Controllers\StudentImportExportController;
use App\Http\Controllers\AcademicSessionController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\FeeCategoryController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Portal\StudentDashboardController;
use App\Http\Controllers\Portal\ParentDashboardController;

// API Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TimetableApiController;
use App\Http\Controllers\Api\GradeApiController;
use App\Http\Controllers\Api\InvoiceApiController;

/*
|--------------------------------------------------------------------------
| Public & Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Standard Laravel UI/Breeze/Jetstream Auth Routes
Auth::routes();

// Explicit Web Logout Route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Web Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Core Dashboards
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/portal', [PortalController::class, 'dashboard'])->name('portal.dashboard');

    // User & Student Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');

    // Report Cards
    Route::get('/report-card/{student}', [ReportCardController::class, 'show'])->name('report.card.show');
    Route::get('/report-card/{student}/download', [ReportCardController::class, 'download'])->name('report.card.download');

    // Messaging
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{thread}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{thread}/reply', [MessageController::class, 'reply'])->name('messages.reply');
});

/*
|--------------------------------------------------------------------------
| Role-Based Routes
|--------------------------------------------------------------------------
*/

// Super Admin
Route::middleware(['auth', 'role:SuperAdmin'])->group(function () {
    Route::resource('schools', SchoolController::class);
});

// School Admin
Route::middleware(['auth', 'role:SchoolAdmin'])->group(function () {
    Route::resource('teacher_profiles', TeacherProfileController::class);
    Route::resource('student_profiles', StudentProfileController::class);
    Route::resource('parent_profiles', ParentProfileController::class);
    
    Route::get('students/import', [StudentImportExportController::class, 'showImportForm'])->name('students.import.form');
    Route::post('students/import', [StudentImportExportController::class, 'import'])->name('students.import');
    Route::get('students/export', [StudentImportExportController::class, 'export'])->name('students.export');

    Route::resource('classroom_assignments', ClassroomAssignmentController::class)->except(['show', 'edit', 'update']);
    Route::resource('timetable', TimetableController::class)->except(['show', 'edit', 'update']);
    Route::resource('sessions', AcademicSessionController::class)->except(['edit', 'update', 'destroy']);
    Route::resource('terms', TermController::class)->except(['edit', 'update', 'destroy']);
    
    Route::get('/attendance/report', [AttendanceController::class, 'attendanceReport'])->name('attendance.report');
    
    // Fees
    Route::get('/fee-categories', [FeeCategoryController::class, 'index'])->name('fee.categories.index');
    Route::post('/fee-categories', [FeeCategoryController::class, 'store'])->name('fee.categories.store');
    Route::get('/fee-structures', [FeeStructureController::class, 'index'])->name('fee.structures.index');
    Route::post('/fee-structures', [FeeStructureController::class, 'store'])->name('fee.structures.store');
});

// Teacher
Route::middleware(['auth', 'role:Teacher'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/take/{class_level}/{section}', [AttendanceController::class, 'takeAttendance'])->name('attendance.take');
    Route::post('/attendance/submit', [AttendanceController::class, 'submitAttendance'])->name('attendance.submit');
});

// Portals
Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});

Route::middleware(['auth', 'role:Parent'])->group(function () {
    Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');
});

/*
|--------------------------------------------------------------------------
| API Routes (Sanctum)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/timetables', [TimetableApiController::class, 'index']);
        Route::get('/grades', [GradeApiController::class, 'index']);
        Route::get('/invoices', [InvoiceApiController::class, 'index']);
    });
});
