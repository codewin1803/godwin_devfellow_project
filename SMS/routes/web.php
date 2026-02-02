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

/* Day 2 */
use App\Http\Controllers\UserController;

/* Day 23 */
use App\Http\Controllers\StudentController;

/* Day 3 */
use App\Http\Controllers\SchoolController;

/* Day 6 */
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\ParentProfileController;
use App\Http\Controllers\ClassroomAssignmentController;

/* Day 7 */
use App\Http\Controllers\StudentImportExportController;

/* Day 8 */
use App\Http\Controllers\AcademicSessionController;
use App\Http\Controllers\TermController;

/* Day 9 – 11 */
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\AttendanceController;

/* Day 14 */
use App\Http\Controllers\ReportCardController;

/* Day 15 */
use App\Http\Controllers\FeeCategoryController;
use App\Http\Controllers\FeeStructureController;

/* Day 16 */
use App\Http\Controllers\PaymentController;

/* Day 18 */
use App\Http\Controllers\AnnouncementController;

/* Day 19 */
use App\Http\Controllers\MessageController;

/* Day 20 */
use App\Http\Controllers\Portal\StudentDashboardController;
use App\Http\Controllers\Portal\ParentDashboardController;

/* Day 21 */
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TimetableApiController;
use App\Http\Controllers\Api\GradeApiController;
use App\Http\Controllers\Api\InvoiceApiController;

/*
|--------------------------------------------------------------------------
| Public Routes (Day 1)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Day 1)
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| CORE DASHBOARDS & KPIs (Day 1 + Day 22)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/portal', [PortalController::class, 'dashboard'])
        ->name('portal.dashboard');
});

/*
|--------------------------------------------------------------------------
| USER MANAGEMENT (Day 2)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
});

/*
|--------------------------------------------------------------------------
| GLOBAL SEARCH & FILTERS (Day 23)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/students', [StudentController::class, 'index'])
        ->name('students.index');
});

/*
|--------------------------------------------------------------------------
| SUPER ADMIN – SCHOOL MANAGEMENT (Day 3)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:SuperAdmin'])->group(function () {

    Route::resource('schools', SchoolController::class);

    Route::get('/admin-only', function () {
        return 'This page is only accessible by SuperAdmin';
    });
});

/*
|--------------------------------------------------------------------------
| SCHOOL ADMIN MODULE (Day 5 – Day 11)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:SchoolAdmin'])->group(function () {

    /* Profiles (Day 6) */
    Route::resource('teacher_profiles', TeacherProfileController::class);
    Route::resource('student_profiles', StudentProfileController::class);
    Route::resource('parent_profiles', ParentProfileController::class);

    /* Student Import / Export (Day 7) */
    Route::get('students/import',
        [StudentImportExportController::class, 'showImportForm']
    )->name('students.import.form');

    Route::post('students/import',
        [StudentImportExportController::class, 'import']
    )->name('students.import');

    Route::get('students/export',
        [StudentImportExportController::class, 'export']
    )->name('students.export');

    /* Classroom Assignments (Day 6) */
    Route::resource('classroom_assignments', ClassroomAssignmentController::class)
        ->except(['show', 'edit', 'update']);

    /* Timetable (Day 9 – 10) */
    Route::resource('timetable', TimetableController::class)
        ->except(['show', 'edit', 'update']);

    /* Academic Sessions (Day 8) */
    Route::resource('sessions', AcademicSessionController::class)
        ->except(['edit', 'update', 'destroy']);

    Route::get('sessions/{session}/activate',
        [AcademicSessionController::class, 'activate']
    )->name('sessions.activate');

    /* Terms (Day 8) */
    Route::resource('terms', TermController::class)
        ->except(['edit', 'update', 'destroy']);

    Route::get('terms/{term}/activate',
        [TermController::class, 'activate']
    )->name('terms.activate');

    /* Attendance Reports (Day 11) */
    Route::get('/attendance/report',
        [AttendanceController::class, 'attendanceReport']
    )->name('attendance.report');
});

/*
|--------------------------------------------------------------------------
| TEACHER MODULE – ATTENDANCE (Day 11)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Teacher'])->group(function () {

    Route::get('/attendance',
        [AttendanceController::class, 'index']
    )->name('attendance.index');

    Route::get('/attendance/take/{class_level}/{section}',
        [AttendanceController::class, 'takeAttendance']
    )->name('attendance.take');

    Route::post('/attendance/submit',
        [AttendanceController::class, 'submitAttendance']
    )->name('attendance.submit');
});

/*
|--------------------------------------------------------------------------
| REPORT CARDS (Day 14)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/report-card/{student}',
        [ReportCardController::class, 'show']
    )->name('report.card.show');

    Route::get('/report-card/{student}/download',
        [ReportCardController::class, 'download']
    )->name('report.card.download');
});

/*
|--------------------------------------------------------------------------
| FEES SETUP (Day 15)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:SchoolAdmin'])->group(function () {

    Route::get('/fee-categories',
        [FeeCategoryController::class, 'index']
    )->name('fee.categories.index');

    Route::post('/fee-categories',
        [FeeCategoryController::class, 'store']
    )->name('fee.categories.store');

    Route::get('/fee-structures',
        [FeeStructureController::class, 'index']
    )->name('fee.structures.index');

    Route::post('/fee-structures',
        [FeeStructureController::class, 'store']
    )->name('fee.structures.store');
});

/*
|--------------------------------------------------------------------------
| PAYMENTS (Day 16)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Bursar|SchoolAdmin'])->group(function () {

    Route::get('/invoices/{invoice}/payments/create',
        [PaymentController::class, 'create']
    )->name('payments.create');

    Route::post('/invoices/{invoice}/payments',
        [PaymentController::class, 'store']
    )->name('payments.store');

    Route::get('/payments/{payment}/receipt',
        [PaymentController::class, 'receipt']
    )->name('payments.receipt');
});

/*
|--------------------------------------------------------------------------
| ANNOUNCEMENTS (Day 18)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:SuperAdmin|SchoolAdmin'])->group(function () {
    Route::resource('announcements', AnnouncementController::class)
        ->except(['show', 'edit', 'update']);
});

/*
|--------------------------------------------------------------------------
| MESSAGING SYSTEM (Day 19)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/messages', [MessageController::class, 'index'])
        ->name('messages.index');

    Route::post('/messages', [MessageController::class, 'store'])
        ->name('messages.store');

    Route::get('/messages/{thread}', [MessageController::class, 'show'])
        ->name('messages.show');

    Route::post('/messages/{thread}/reply', [MessageController::class, 'reply'])
        ->name('messages.reply');
});

/*
|--------------------------------------------------------------------------
| STUDENT & PARENT PORTALS (Day 20)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('/student/dashboard',
        [StudentDashboardController::class, 'index']
    )->name('student.dashboard');
});

Route::middleware(['auth', 'role:Parent'])->group(function () {
    Route::get('/parent/dashboard',
        [ParentDashboardController::class, 'index']
    )->name('parent.dashboard');
});

/*
|--------------------------------------------------------------------------
| PUBLIC API ROUTES (Day 21)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/timetables', [TimetableApiController::class, 'index']);
    Route::get('/grades', [GradeApiController::class, 'index']);
    Route::get('/invoices', [InvoiceApiController::class, 'index']);
});
