<?php
namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public $successCount = 0;
    public $errorRows = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $data = [
                'name' => $row['name'] ?? null,
                'email' => $row['email'] ?? null,
                'classroom_id' => $row['classroom_id'] ?? null,
            ];

            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
                'classroom_id' => 'required|exists:classrooms,id',
            ]);

            if ($validator->fails()) {
                $this->errorRows[] = [
                    'row' => $index + 2, // +2 for heading row offset
                    'errors' => $validator->errors()->all()
                ];
                continue;
            }

            Student::create($data);
            $this->successCount++;
        }
    }
}
