<?php

namespace App\Imports;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\ClassLevel;
use App\Models\Section;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        // create user
        $password = Str::random(8);

        $user = User::create([
            'name'  => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($password),
            'school_id' => session('active_school'),
        ]);

        if (method_exists($user,'assignRole')) {
            $user->assignRole('Student');
        }

        // map class & section
        $classLevel = ClassLevel::where('name', $row['class_level'])->first();
        $section = Section::where('name', $row['section'])->first();

        // create profile
        return new StudentProfile([
            'user_id' => $user->id,
            'admission_no' => $row['admission_no'],
            'date_of_birth' => $row['date_of_birth'],
            'gender' => $row['gender'],
            'class_level_id' => optional($classLevel)->id,
            'section_id' => optional($section)->id,
            'school_id' => session('active_school'),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name' => ['required'],
            '*.email' => ['required','email','unique:users,email'],
            '*.admission_no' => ['nullable','unique:student_profiles,admission_no'],
            '*.date_of_birth' => ['nullable'],
            '*.gender' => ['nullable'],
            '*.class_level' => ['nullable'],
            '*.section' => ['nullable'],
        ];
    }
}
