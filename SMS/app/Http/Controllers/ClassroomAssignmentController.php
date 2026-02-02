<?php

namespace App\Http\Controllers;

use App\Models\ClassroomAssignment;
use App\Models\TeacherProfile;
use App\Models\ClassLevel;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassroomAssignmentController extends Controller
{
    public function index()
    {
        $assignments = ClassroomAssignment::with(['teacher.user','classLevel','section','subject'])->get();
        return view('classroom_assignments.index', compact('assignments'));
    }

    public function create()
    {
        $teachers = TeacherProfile::with('user')->get();
        $classLevels = ClassLevel::all();
        $sections = Section::all();
        $subjects = Subject::all();
        return view('classroom_assignments.create', compact('teachers','classLevels','sections','subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_profile_id'=>'required|exists:teacher_profiles,id',
            'class_level_id'=>'required|exists:class_levels,id',
            'section_id'=>'nullable|exists:sections,id',
            'subject_id'=>'required|exists:subjects,id',
        ]);

        ClassroomAssignment::create([
            'teacher_profile_id'=>$request->teacher_profile_id,
            'class_level_id'=>$request->class_level_id,
            'section_id'=>$request->section_id,
            'subject_id'=>$request->subject_id,
            'school_id'=>session('active_school'),
        ]);

        return redirect()->route('classroom_assignments.index')->with('success','Assignment created');
    }

    public function destroy(ClassroomAssignment $classroomAssignment)
    {
        $classroomAssignment->delete();
        return back()->with('success','Assignment removed');
    }
}
