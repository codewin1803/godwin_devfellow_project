<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function __construct()
    {
        // Only authenticated SchoolAdmins can manage timetables
        $this->middleware(['auth', 'role:SchoolAdmin']);
    }

    /**
     * Display all timetable entries for the current school.
     */
    public function index()
    {
        // Load timetable entries with related class, section, subject, and teacher data
        $entries = Timetable::where('school_id', session('active_school'))
            ->with(['classLevel','section','subject','teacher.user'])
            ->orderBy('weekday')
            ->orderBy('start_time')
            ->get();

        return view('timetable.index', compact('entries'));
    }

    /**
     * Show the form for creating a new timetable entry.
     */
    public function create()
    {
        // Load dropdown data
        $classLevels = \App\Models\ClassLevel::all();
        $sections = \App\Models\Section::all();
        $subjects = \App\Models\Subject::all();
        $teachers = \App\Models\TeacherProfile::with('user')->get();

        return view('timetable.create', compact('classLevels','sections','subjects','teachers'));
    }

    /**
     * Store a new timetable entry.
     * This includes validation + time overlap protection.
     */
    public function store(Request $request)
    {
        // Validate input fields
        $request->validate([
            'class_level_id'       => 'required',
            'section_id'           => 'required',
            'subject_id'           => 'required',
            'teacher_profile_id'   => 'required',
            'weekday'              => 'required|string',
            'start_time'           => 'required',
            'end_time'             => 'required|after:start_time',
        ]);

        /**
         * 1. Check TEACHER time conflict
         * A teacher cannot be scheduled for two classes at the same time on the same day.
         */
        $teacherConflict = Timetable::where('teacher_profile_id', $request->teacher_profile_id)
            ->where('weekday', $request->weekday)
            ->where('school_id', session('active_school'))
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        if ($teacherConflict) {
            return back()->withErrors('This teacher already has a class during this time.');
        }

        /**
         * 2. Check CLASS time conflict
         * A class cannot have two subjects at the same time.
         */
        $classConflict = Timetable::where('class_level_id', $request->class_level_id)
            ->where('section_id', $request->section_id)
            ->where('weekday', $request->weekday)
            ->where('school_id', session('active_school'))
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        if ($classConflict) {
            return back()->withErrors('This class already has another subject during this time.');
        }

        /**
         * 3. Save timetable entry
         */
        Timetable::create([
            'class_level_id'     => $request->class_level_id,
            'section_id'         => $request->section_id,
            'subject_id'         => $request->subject_id,
            'teacher_profile_id' => $request->teacher_profile_id,
            'weekday'            => $request->weekday,
            'start_time'         => $request->start_time,
            'end_time'           => $request->end_time,
            'school_id'          => session('active_school'),
        ]);

        return redirect()->route('timetable.index')->with('success', 'Timetable entry added successfully.');
    }


    /**
     * NOT USED in this module (but required by resource controller).
     */
    public function show(Timetable $timetable)
    {
        //
    }

    /**
     * NOT USED (editing is planned for future days).
     */
    public function edit(Timetable $timetable)
    {
        //
    }

    /**
     * NOT USED (updating is planned for future days).
     */
    public function update(Request $request, Timetable $timetable)
    {
        //
    }

    /**
     * Delete a timetable entry.
     */
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return back()->with('success', 'Timetable entry deleted.');
    }
}
