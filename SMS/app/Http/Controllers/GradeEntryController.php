<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\StudentProfile;
use App\Models\Subject;

class GradeEntryController extends Controller
{
    // Show grade entry form for a subject
    public function index($subjectId)
    {
        $subject = Subject::findOrFail($subjectId);
        $students = StudentProfile::all(); // Adjust if class-specific
        $grades = Grade::where('subject_id', $subjectId)->pluck('score', 'student_id')->toArray();

        return view('grades.entry', compact('subject', 'students', 'grades'));
    }

    // Store grades
    public function store(Request $request, $subjectId)
    {
        $data = $request->validate([
            'grades.*' => 'nullable|integer|min:0|max:100'
        ]);

        foreach ($data['grades'] as $studentId => $score) {
            Grade::updateOrCreate(
                ['student_id' => $studentId, 'subject_id' => $subjectId],
                ['score' => $score]
            );
        }

        return redirect()->back()->with('success', 'Grades saved successfully!');
    }

    // Lock grades
    public function lock($subjectId)
    {
        Grade::where('subject_id', $subjectId)->update(['is_locked' => true]);
        return redirect()->back()->with('success', 'Grades locked successfully!');
    }
}

