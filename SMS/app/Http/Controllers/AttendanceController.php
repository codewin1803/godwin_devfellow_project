<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance.
     */
    public function index()
    {
        $this->authorize('viewAny', Attendance::class);

        $attendances = Attendance::with('student')
            ->where('school_id', Auth::user()->school_id)
            ->latest()
            ->get();

        return view('attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating attendance.
     */
    public function create()
    {
        $this->authorize('create', Attendance::class);

        $students = StudentProfile::where('school_id', Auth::user()->school_id)->get();

        return view('attendance.create', compact('students'));
    }

    /**
     * Store newly created attendance.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Attendance::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:student_profiles,id'],
            'date'       => ['required', 'date'],
            'status'     => ['required', 'in:PRESENT,ABSENT,LATE'],
        ]);

        Attendance::create([
            'student_id' => $validated['student_id'],
            'teacher_id' => Auth::id(),
            'school_id'  => Auth::user()->school_id,
            'date'       => $validated['date'],
            'status'     => $validated['status'],
        ]);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Show the form for editing attendance.
     */
    public function edit(Attendance $attendance)
    {
        $this->authorize('update', $attendance);

        return view('attendance.edit', compact('attendance'));
    }

    /**
     * Update attendance.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $this->authorize('update', $attendance);

        $validated = $request->validate([
            'status' => ['required', 'in:PRESENT,ABSENT,LATE'],
        ]);

        $attendance->update($validated);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove attendance.
     */
    public function destroy(Attendance $attendance)
    {
        $this->authorize('delete', $attendance);

        $attendance->delete();

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance deleted successfully.');
    }
}
