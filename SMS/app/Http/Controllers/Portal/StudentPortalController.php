<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Invoice;
use App\Models\Grade;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user()->studentProfile;

        $attendanceCount = Attendance::where('student_id', $student->id)->count();
        $invoices = Invoice::where('student_id', $student->id)->get();
        $grades = Grade::where('student_id', $student->id)->get();

        return view('portal.student.dashboard', compact(
            'student',
            'attendanceCount',
            'invoices',
            'grades'
        ));
    }
}
