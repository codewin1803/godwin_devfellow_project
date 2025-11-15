<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassLevelController extends Controller
{
    /**
     * Restrict access: only SchoolAdmin
     */
    public function __construct()
    {
        $this->middleware('role:SchoolAdmin');
    }

    /**
     * Display all class levels belonging to the current school.
     */
    public function index()
    {
        $classLevels = ClassLevel::where('school_id', Auth::user()->school_id)->get();
        return view('class_levels.index', compact('classLevels'));
    }

    /**
     * Store a newly created class level.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:class_levels,code,NULL,id,school_id,' . Auth::user()->school_id,
        ]);

        ClassLevel::create([
            'name' => $request->name,
            'code' => $request->code,
            'school_id' => Auth::user()->school_id,
        ]);

        return redirect()->back()->with('success', 'Class level created successfully.');
    }

    /**
     * Edit a specific class level (AJAX modal or normal form).
     */
    public function edit(ClassLevel $classLevel)
    {
        $this->authorizeAccess($classLevel);
        return response()->json($classLevel);
    }

    /**
     * Update the specified class level.
     */
    public function update(Request $request, ClassLevel $classLevel)
    {
        $this->authorizeAccess($classLevel);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:class_levels,code,' . $classLevel->id . ',id,school_id,' . Auth::user()->school_id,
        ]);

        $classLevel->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->back()->with('success', 'Class level updated successfully.');
    }

    /**
     * Delete a class level.
     */
    public function destroy(ClassLevel $classLevel)
    {
        $this->authorizeAccess($classLevel);
        $classLevel->delete();

        return redirect()->back()->with('success', 'Class level deleted successfully.');
    }

    /**
     * Ensure the record belongs to the same school as the logged-in user.
     */
    private function authorizeAccess(ClassLevel $classLevel)
    {
        if ($classLevel->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
