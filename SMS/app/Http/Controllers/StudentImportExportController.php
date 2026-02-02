<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentImportExportController extends Controller
{
    public function showImportForm()
    {
        return view('student_import.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required','mimes:xlsx,csv']
        ]);

        $import = new StudentsImport;

        $import->import($request->file('file'));

        if ($import->failures()->isNotEmpty()) {
            return back()->with('failures', $import->failures());
        }

        return back()->with('success','Students imported successfully.');
    }

    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }
}
