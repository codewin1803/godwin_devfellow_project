<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ClassLevelController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentImportExportController;
use App\Http\Controllers\AcademicSessionController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\TimetableViewController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AssessmentTypeController;
use App\Http\Controllers\GradeEntryController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\FeeCategoryController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentRecordController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\MessageThreadController;
use App\Http\Controllers\MessageController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group.
|
*/

// Default Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (Login, Register, etc.)
Auth::routes();

// Common Dashboard (visible to all logged-in users)
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');

/*
|--------------------------------------------------------------------------
| SUPERADMIN ROUTES
|--------------------------------------------------------------------------
| Can manage all schools and top-level system configuration.
*/
Route::middleware(['auth', 'role:SuperAdmin'])->group(function () {
    Route::get('/superadmin/dashboard', function () {
        return view('roles.superadmin');
    })->name('superadmin.dashboard');

    // Manage schools
    Route::resource('schools', SchoolController::class);
});

/*
|--------------------------------------------------------------------------
| SCHOOL ADMIN ROUTES
|--------------------------------------------------------------------------
| Can manage academic structure and users within their school.
*/
Route::middleware(['auth', 'role:SchoolAdmin'])->group(function () {
    Route::get('/schooladmin/dashboard', function () {
        return view('roles.schooladmin');
    })->name('schooladmin.dashboard');

    // Academic Structure
    Route::resource('class-levels', ClassLevelController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('subjects', SubjectController::class);

    // Academic Sessions
    Route::get('/sessions', [AcademicSessionController::class, 'index']);
    Route::post('/sessions/store', [AcademicSessionController::class, 'store']);
    Route::get('/sessions/{session}/activate', [AcademicSessionController::class, 'activate']);

    // Terms
    Route::get('/terms', [TermController::class, 'index']);
    Route::post('/terms/store', [TermController::class, 'store']);
    Route::get('/terms/{term}/activate', [TermController::class, 'activate']);

    // Bulk Import/Export Students
    Route::get('students/export', [StudentImportExportController::class, 'export'])->name('students.export');
    Route::post('students/import', [StudentImportExportController::class, 'import'])->name('students.import');
});

/*
|--------------------------------------------------------------------------
| TEACHER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('roles.teacher');
    })->name('teacher.dashboard');

    // Attendance
    Route::get('attendance/{class_id}/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance/{class_id}/summary', [AttendanceController::class, 'summary'])->name('attendance.summary');
    Route::get('attendance/{class_id}/export', [AttendanceController::class, 'export'])->name('attendance.export');

    // Timetable management
    Route::get('timetable', [App\Http\Controllers\TimetableController::class, 'index'])->name('timetable.index');
    Route::post('timetable', [App\Http\Controllers\TimetableController::class, 'store'])->name('timetable.store');

    // Report Cards
    Route::get('/report-cards', [ReportCardController::class, 'index']);
    Route::get('/report-cards/{studentId}/pdf', [ReportCardController::class, 'generate']);
    Route::get('/report-cards/batch/pdf', [ReportCardController::class, 'batch']);
});

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('roles.student');
    })->name('student.dashboard');
});

/*
|--------------------------------------------------------------------------
| PARENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Parent'])->group(function () {
    Route::get('/parent/dashboard', function () {
        return view('roles.parent');
    })->name('parent.dashboard');
});

/*
|--------------------------------------------------------------------------
| BURSAR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Bursar'])->group(function () {
    Route::get('/bursar/dashboard', function () {
        return view('roles.bursar');
    })->name('bursar.dashboard');

    // Fee Management
    Route::resource('fee-categories', FeeCategoryController::class)
        ->only(['index', 'create', 'store', 'destroy']);
    Route::resource('fee-structures', FeeStructureController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    // Invoices
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/generate', [InvoiceController::class, 'generateForm'])->name('invoices.generate');
    Route::post('invoices/generate', [InvoiceController::class, 'generateInvoices'])->name('invoices.generate.run');
    Route::get('invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

    // Payments
    Route::post('invoices/{invoice_id}/pay', [PaymentController::class, 'pay'])->name('invoice.pay');

    // Payment Records
    Route::get('payments/create/{invoice_id}', [PaymentRecordController::class, 'create'])->name('payments.create');
    Route::post('payments/store/{invoice_id}', [PaymentRecordController::class, 'store'])->name('payments.store');
    Route::get('payments/receipt/{payment_id}', [PaymentRecordController::class, 'receipt'])->name('payments.receipt');

    // Finance Dashboard
    Route::prefix('finance')->group(function(){
        Route::get('/', [FinanceController::class, 'index'])->name('finance.index');
        Route::get('/export', [FinanceController::class, 'export'])->name('finance.export');
    });
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
| For managing assessments and grades
*/
Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Assessment Type Routes
    Route::get('assessments/{subject_id}', [AssessmentTypeController::class, 'index'])->name('assessments.index');
    Route::get('assessments/{subject_id}/create', [AssessmentTypeController::class, 'create'])->name('assessments.create');
    Route::post('assessments/{subject_id}', [AssessmentTypeController::class, 'store'])->name('assessments.store');
    Route::get('assessments/{subject_id}/{assessmentType}/edit', [AssessmentTypeController::class, 'edit'])->name('assessments.edit');
    Route::put('assessments/{subject_id}/{assessmentType}', [AssessmentTypeController::class, 'update'])->name('assessments.update');
    Route::delete('assessments/{subject_id}/{assessmentType}', [AssessmentTypeController::class, 'destroy'])->name('assessments.destroy');

    // Grade Entry Routes
    Route::prefix('grades')->group(function () {
        Route::get('entry/{subjectId}', [GradeEntryController::class, 'index'])->name('grades.entry');
        Route::post('entry/{subjectId}', [GradeEntryController::class, 'store'])->name('grades.store');
        Route::patch('lock/{subjectId}', [GradeEntryController::class, 'lock'])->name('grades.lock');
    });

    // Announcements
    Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
});



// Message Routes
Route::middleware(['auth'])->group(function () {

    // Threads
    Route::get('messages', [MessageThreadController::class, 'index'])->name('messages.index');
    Route::get('messages/create', [MessageThreadController::class, 'create'])->name('messages.create');
    Route::post('messages', [MessageThreadController::class, 'store'])->name('messages.store');
    Route::get('messages/{thread}', [MessageThreadController::class, 'show'])->name('messages.show');

    // Messages (replies, attachments)
    Route::post('messages/{thread}/send', [MessageController::class, 'store'])->name('messages.send');
    Route::get('messages/attachment/{message}', [MessageController::class, 'attachmentDownload'])->name('messages.attachment');
    Route::post('messages/{message}/mark-read', [MessageController::class, 'markRead'])->name('messages.markread');

});