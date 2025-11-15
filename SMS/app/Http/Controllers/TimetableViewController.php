<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\ClassLevel;
use App\Models\User; // Assuming teachers are Users
use Illuminate\Http\Request;

class TimetableViewController extends Controller
{
    // Restrict access to authenticated users
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display timetable grid with optional filters.
     */
    public function index(Request $request)
    {
        $classes = ClassLevel::all();
        $teachers = User::role('Teacher')->get();

        $query = Timetable::query();

        if ($request->filled('class_level_id')) {
            $query->where('class_level_id', $request->class_level_id);
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $timetables = $query->get();

        return view('timetable.index', compact('timetables', 'classes', 'teachers'));
    }

    /**
     * Export timetable filtered by class or teacher
     */
    public function export(Request $request)
    {
        $query = Timetable::query();

        if ($request->filled('class_level_id')) {
            $query->where('class_level_id', $request->class_level_id);
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $timetables = $query->get();

        // Simple CSV export
        $filename = 'timetable.csv';
        $handle = fopen($filename, 'w');
        fputcsv($handle, ['Class', 'Teacher', 'Subject', 'Weekday', 'Start Time', 'End Time']);

        foreach ($timetables as $t) {
            fputcsv($handle, [
                $t->classLevel->name ?? '',
                $t->teacher->name ?? '',
                $t->subject->name ?? '',
                $t->weekday,
                $t->start_time,
                $t->end_time
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
