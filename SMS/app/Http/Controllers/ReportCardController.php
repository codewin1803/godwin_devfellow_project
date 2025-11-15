<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

class ReportCardController extends Controller
{
    /**
     * List all students in the classroom
     */
    public function index($classroom_id)
    {
        $classroom = Classroom::with('students')
            ->where('school_id', Auth::user()->school_id)
            ->findOrFail($classroom_id);

        return view('report_cards.index', compact('classroom'));
    }

    /**
     * Download a single student's report card PDF
     */
    public function download($student_id)
    {
        $student = StudentProfile::with(['classroom', 'grades.subject'])
            ->where('school_id', Auth::user()->school_id)
            ->findOrFail($student_id);

        $average = round($student->grades->avg('score'), 2);

        $data = [
            'student' => $student,
            'grades'  => $student->grades,
            'average' => $average,
            'remark'  => $this->makeRemark($average),
        ];

        $pdf = Pdf::loadView('report_cards.card', $data);

        $fileName = $student->full_name . '_report_card.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Download all student report cards as a ZIP
     */
    public function batch($classroom_id)
    {
        $classroom = Classroom::with('students.grades.subject')
            ->where('school_id', Auth::user()->school_id)
            ->findOrFail($classroom_id);

        $zipName = "class_{$classroom->id}_report_cards.zip";
        $zipPath = storage_path("app/public/{$zipName}");

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {

            foreach ($classroom->students as $student) {

                $average = round($student->grades->avg('score'), 2);

                $data = [
                    'student' => $student,
                    'grades'  => $student->grades,
                    'average' => $average,
                    'remark'  => $this->makeRemark($average),
                ];

                // Generate PDF in memory
                $pdf = Pdf::loadView('report_cards.card', $data);

                // Temporary PDF path
                $tempPath = storage_path("app/temp/{$student->id}.pdf");

                // Ensure temp folder exists
                Storage::disk('local')->makeDirectory('temp');

                // Save PDF
                file_put_contents($tempPath, $pdf->output());

                // Add to ZIP
                $zip->addFile($tempPath, $student->full_name . '.pdf');
            }

            $zip->close();
        }

        // Send ZIP and delete after sending
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Generate student remark from average score
     */
    private function makeRemark($avg)
    {
        if ($avg >= 75) return "Excellent Performance";
        if ($avg >= 60) return "Very Good";
        if ($avg >= 50) return "Good";
        if ($avg >= 40) return "Fair – Needs Improvement";
        return "Poor – Serious Improvement Needed";
    }
}
