<?php
namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class StudentImportExportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        $import = new StudentsImport();
        Excel::import($import, $request->file('file'));

        return back()->with([
            'success' => "{$import->successCount} students imported successfully!",
            'errors' => $import->errorRows,
        ]);
    }

    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }
}
