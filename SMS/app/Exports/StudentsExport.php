<?php

namespace App\Exports;

use App\Models\StudentProfile;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection
{
    public function collection()
    {
        return StudentProfile::with(['user','classLevel','section'])
            ->get()
            ->map(function ($student) {
                return [
                    'name'          => $student->user->name,
                    'email'         => $student->user->email,
                    'admission_no'  => $student->admission_no,
                    'date_of_birth' => $student->date_of_birth,
                    'gender'        => $student->gender,
                    'class_level'   => optional($student->classLevel)->name,
                    'section'       => optional($student->section)->name,
                ];
            });
    }
}
