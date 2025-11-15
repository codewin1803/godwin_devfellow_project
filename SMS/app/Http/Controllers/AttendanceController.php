<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Teacher'); // Only teachers can record
    }

    // Show daily attendance form for a class
    public function create(Request $request, $class_id)
    {
        $students = Student::where('class_level_id', $class_id)->get();
        return view('attendance.create', compact('students'));
    }

    // Store attendance
    public function store(Request $request)
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*' => 'in:PRESENT,ABSENT,LATE',
            'date' => 'required|date',
        ]);

        foreach ($request->attendance as $student_id => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $student_id, 'date' => $request->date],
                ['status' => $status]
            );
        }

        return redirect()->back()->with('success', 'Attendance recorded successfully.');
    }

    // Show class summary
    public function summary($class_id)
    {
        $attendances = Attendance::whereHas('student', function($q) use ($class_id) {
            $q->where('class_level_id', $class_id);
        })->orderBy('date', 'desc')->get();

        return view('attendance.summary', compact('attendances'));
    }

    // Export class attendance to CSV
    public function export($class_id)
    {
        $attendances = Attendance::whereHas('student', function($q) use ($class_id) {
            $q->where('class_level_id', $class_id);
        })->get();

        $filename = 'attendance.csv';
        $handle = fopen($filename, 'w');
        fputcsv($handle, ['Student', 'Date', 'Status']);

        foreach ($attendances as $a) {
            fputcsv($handle, [
                $a->student->name ?? '',
                $a->date,
                $a->status
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
