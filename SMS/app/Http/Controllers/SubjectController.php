<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        Subject::create([
            'name' => $request->name,
            'code' => $request->code,
            'school_id' => session('active_school'),
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject created');
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate(['name' => 'required']);

        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Updated successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'Subject deleted');
    }
}
