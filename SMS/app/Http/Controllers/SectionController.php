<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\ClassLevel;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('classLevel')->get();
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        $classLevels = ClassLevel::all();
        return view('sections.create', compact('classLevels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'class_level_id' => 'required',
        ]);

        Section::create([
            'name' => $request->name,
            'class_level_id' => $request->class_level_id,
            'school_id' => session('active_school'),
        ]);

        return redirect()->route('sections.index')->with('success', 'Section created');
    }

    public function edit(Section $section)
    {
        $classLevels = ClassLevel::all();
        return view('sections.edit', compact('section', 'classLevels'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'name' => 'required',
            'class_level_id' => 'required',
        ]);

        $section->update([
            'name' => $request->name,
            'class_level_id' => $request->class_level_id,
        ]);

        return redirect()->route('sections.index')->with('success', 'Updated successfully');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return back()->with('success', 'Section deleted');
    }
}
