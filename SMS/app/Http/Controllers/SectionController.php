<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Restrict access: only SchoolAdmin
     */
    public function __construct()
    {
        $this->middleware('role:SchoolAdmin');
    }

    /**
     * Display all sections belonging to the current school.
     */
    public function index()
    {
        $sections = Section::where('school_id', Auth::user()->school_id)->get();
        return view('sections.index', compact('sections'));
    }

    /**
     * Store a newly created section.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:sections,code,NULL,id,school_id,' . Auth::user()->school_id,
        ]);

        Section::create([
            'name' => $request->name,
            'code' => $request->code,
            'school_id' => Auth::user()->school_id,
        ]);

        return redirect()->back()->with('success', 'Section created successfully.');
    }

    /**
     * Edit a specific section (AJAX modal or normal form).
     */
    public function edit(Section $section)
    {
        $this->authorizeAccess($section);
        return response()->json($section);
    }

    /**
     * Update the specified section.
     */
    public function update(Request $request, Section $section)
    {
        $this->authorizeAccess($section);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:sections,code,' . $section->id . ',id,school_id,' . Auth::user()->school_id,
        ]);

        $section->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->back()->with('success', 'Section updated successfully.');
    }

    /**
     * Delete a section.
     */
    public function destroy(Section $section)
    {
        $this->authorizeAccess($section);
        $section->delete();

        return redirect()->back()->with('success', 'Section deleted successfully.');
    }

    /**
     * Ensure the record belongs to the same school as the logged-in user.
     */
    private function authorizeAccess(Section $section)
    {
        if ($section->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
