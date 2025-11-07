<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display all schools.
     */
    public function index()
    {
        $schools = School::latest()->get();
        return view('schools.index', compact('schools'));
    }

    /**
     * Show form to create a new school.
     */
    public function create()
    {
        return view('schools.create');
    }

    /**
     * Store a newly created school.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:schools,email',
        ]);

        School::create($validated);

        return redirect()->route('schools.index')->with('success', 'School added successfully!');
    }

    /**
     * Show the form for editing a school.
     */
    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    /**
     * Update an existing school.
     */
    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:schools,email,' . $school->id,
        ]);

        $school->update($validated);

        return redirect()->route('schools.index')->with('success', 'School updated successfully!');
    }

    /**
     * Delete a school.
     */
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('schools.index')->with('success', 'School deleted successfully!');
    }
}
