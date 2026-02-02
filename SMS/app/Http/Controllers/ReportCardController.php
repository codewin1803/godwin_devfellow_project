<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\Grade;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportCardController extends Controller
{
    public function __construct()
    {
        // Only authenticated users can view report cards
        $this->middleware('auth');
    }

    /**
     * Display the report card in the browser.
     */
    public function show(StudentProfile $student)
    {
        // Get all grades for this student in the active school
        $grades = Grade::with('assessmentType')
            ->where('student_profile_id', $student->id)
            ->where('school_id', session('active_school'))
            ->get();

        return view('reports.card', compact('student', 'grades'));
    }

    /**
     * Download the report card as a PDF.
     */
    public function download(StudentProfile $student)
    {
        $grades = Grade::with('assessmentType')
            ->where('student_profile_id', $student->id)
            ->where('school_id', session('active_school'))
            ->get();

        // Load Blade view into PDF
        $pdf = Pdf::loadView('reports.card_pdf', compact('student', 'grades'));

        return $pdf->download('report_card_'.$student->id.'.pdf');
    }
}
