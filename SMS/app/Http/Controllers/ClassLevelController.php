<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use Illuminate\Http\Request;

class ClassLevelController extends Controller
{
    public function index()
    {
        $classLevels = ClassLevel::all();
        return view('class_levels.index', compact('classLevels'));
    }

    public function create()
    {
        return view('class_levels.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        ClassLevel::create([
            'name' => $request->name,
            'school_id' => session('active_school'),
        ]);

        return redirect()->route('class_levels.index')->with('success', 'Class Level created');
    }

    public function edit(ClassLevel $classLevel)
    {
        return view('class_levels.edit', compact('classLevel'));
    }

    public function update(Request $request, ClassLevel $classLevel)
    {
        $request->validate(['name' => 'required']);

        $classLevel->update(['name' => $request->name]);

        return redirect()->route('class_levels.index')->with('success', 'Updated successfully');
    }

    public function destroy(ClassLevel $classLevel)
    {
        $classLevel->delete();
        return back()->with('success', 'Class Level deleted');
    }
}
