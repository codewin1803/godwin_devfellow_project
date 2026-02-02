<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\ClassLevel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = StudentProfile::with(['user', 'classLevel'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->search . '%');
                });
            })

            ->when($request->class_id, function ($q) use ($request) {
                $q->where('class_level_id', $request->class_id);
            })

            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })

            ->paginate(10)
            ->withQueryString();

        $classes = ClassLevel::all();

        return view('students.index', compact('students', 'classes'));
    }
}
