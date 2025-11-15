<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Restrict access: only SchoolAdmin
     */
    public function __construct()
    {
        $this->middleware('role:SchoolAdmin');
    }

    /**
     * Display all subjects belonging to the current school.
     */
    public function index()
    {
        $subjects = Subject::where('school_id', Auth::user()->school_id)->get();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Store a newly created subject.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,NULL,id,school_id,' . Auth::user()->school_id,
        ]);

        Subject::create([
            'name' => $request->name,
            'code' => $request->code,
            'school_id' => Auth::user()->school_id,
        ]);

        return redirect()->back()->with('success', 'Subject created successfully.');
    }

    /**
     * Edit a specific subject (AJAX modal or normal form).
     */
    public function edit(Subject $subject)
    {
        $this->authorizeAccess($subject);
        return response()->json($subject);
    }

    /**
     * Update the specified subject.
     */
    public function update(Request $request, Subject $subject)
    {
        $this->authorizeAccess($subject);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id . ',id,school_id,' . Auth::user()->school_id,
        ]);

        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    /**
     * Delete a subject.
     */
    public function destroy(Subject $subject)
    {
        $this->authorizeAccess($subject);
        $subject->delete();

        return redirect()->back()->with('success', 'Subject deleted successfully.');
    }

    /**
     * Ensure the record belongs to the same school as the logged-in user.
     */
    private function authorizeAccess(Subject $subject)
    {
        if ($subject->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
