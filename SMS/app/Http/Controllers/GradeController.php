<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\StudentProfile;
use App\Models\AssessmentType;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct()
    {
        // Teachers enter grades
        $this->middleware(['auth','role:Teacher']);
    }

    /**
     * Show grade entry form.
     */
    public function index()
    {
        $students = StudentProfile::all();
        $assessments = AssessmentType::all();

        return view('grades.index', compact('students','assessments'));
    }

    /**
     * Store grades.
     */
    public function store(Request $request)
    {
        foreach ($request->scores as $studentId => $scores) {
            foreach ($scores as $assessmentId => $score) {
                Grade::updateOrCreate(
                    [
                        'student_profile_id'=>$studentId,
                        'assessment_type_id'=>$assessmentId,
                    ],
                    [
                        'score'=>$score,
                        'school_id'=>session('active_school'),
                    ]
                );
            }
        }

        return back()->with('success','Grades saved.');
    }
}
