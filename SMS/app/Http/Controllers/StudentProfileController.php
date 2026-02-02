<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\User;
use App\Models\ClassLevel;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentProfileController extends Controller
{
    public function index()
    {
        $students = StudentProfile::with(['user','classLevel','section'])->get();
        return view('student_profiles.index', compact('students'));
    }

    public function create()
    {
        $classLevels = ClassLevel::all();
        $sections = Section::all();
        return view('student_profiles.create', compact('classLevels','sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'admission_no'=>'nullable|string|unique:student_profiles,admission_no',
            'date_of_birth'=>'nullable|date',
            'gender'=>'nullable|string',
            'class_level_id'=>'nullable|exists:class_levels,id',
            'section_id'=>'nullable|exists:sections,id',
        ]);

        $password = Str::random(8);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($password),
            'school_id'=>session('active_school'),
        ]);

        if (method_exists($user,'assignRole')) {
            $user->assignRole('Student');
        }

        StudentProfile::create([
            'user_id'=>$user->id,
            'admission_no'=>$request->admission_no,
            'date_of_birth'=>$request->date_of_birth,
            'gender'=>$request->gender,
            'class_level_id'=>$request->class_level_id,
            'section_id'=>$request->section_id,
            'school_id'=>session('active_school'),
        ]);

        return redirect()->route('student_profiles.index')->with('success','Student created');
    }

    public function edit(StudentProfile $studentProfile)
    {
        $classLevels = ClassLevel::all();
        $sections = Section::where('class_level_id', $studentProfile->class_level_id)->get();
        return view('student_profiles.edit', compact('studentProfile','classLevels','sections'));
    }

    public function update(Request $request, StudentProfile $studentProfile)
    {
        $request->validate([
            'admission_no'=>'nullable|string|unique:student_profiles,admission_no,'.$studentProfile->id,
            'date_of_birth'=>'nullable|date',
            'class_level_id'=>'nullable|exists:class_levels,id',
            'section_id'=>'nullable|exists:sections,id',
        ]);

        $studentProfile->update($request->only(['admission_no','date_of_birth','gender','class_level_id','section_id']));

        if ($request->filled('name')) {
            $studentProfile->user->update(['name'=>$request->name]);
        }

        return redirect()->route('student_profiles.index')->with('success','Student updated');
    }

    public function destroy(StudentProfile $studentProfile)
    {
        $studentProfile->user->delete();
        return back()->with('success','Student deleted');
    }
}
