<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TimetableController extends Controller
{
    /**
     * Display a listing of the timetable.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $timetables = Timetable::where('school_id', $user->school_id)
            ->orderBy('weekday')
            ->orderBy('start_time')
            ->get();

        return view('timetables.index', compact('timetables'));
    }

    /**
     * Show the form for creating a new timetable entry.
     */
    public function create()
    {
        return view('timetables.create');
    }

    /**
     * Store a newly created timetable entry.
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'class_level_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'weekday' => 'required|integer|min:1|max:7',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // Check for overlapping timetable
        $overlap = Timetable::where('school_id', $user->school_id)
            ->where('teacher_id', $request->teacher_id)
            ->where('weekday', $request->weekday)
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('start_time', '<=', $request->start_time)
                         ->where('end_time', '>=', $request->end_time);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors('Teacher already has a class at this time.');
        }

        Timetable::create([
            'school_id' => $user->school_id,
            'class_level_id' => $request->class_level_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'weekday' => $request->weekday,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Class added to timetable.');
    }

    /**
     * Show the form for editing a timetable entry.
     */
    public function edit(Timetable $timetable)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($timetable->school_id !== $user->school_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('timetables.edit', compact('timetable'));
    }

    /**
     * Update the specified timetable entry.
     */
    public function update(Request $request, Timetable $timetable)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($timetable->school_id !== $user->school_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'class_level_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'weekday' => 'required|integer|min:1|max:7',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // Check for overlapping timetable excluding current entry
        $overlap = Timetable::where('school_id', $user->school_id)
            ->where('teacher_id', $request->teacher_id)
            ->where('weekday', $request->weekday)
            ->where('id', '!=', $timetable->id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('start_time', '<=', $request->start_time)
                         ->where('end_time', '>=', $request->end_time);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors('Teacher already has a class at this time.');
        }

        $timetable->update([
            'class_level_id' => $request->class_level_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'weekday' => $request->weekday,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Timetable updated successfully.');
    }

    /**
     * Remove the specified timetable entry.
     */
    public function destroy(Timetable $timetable)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($timetable->school_id !== $user->school_id) {
            abort(403, 'Unauthorized action.');
        }

        $timetable->delete();

        return back()->with('success', 'Timetable entry deleted successfully.');
    }
}
