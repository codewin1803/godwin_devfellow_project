<?php

namespace App\Http\Controllers;

use App\Models\AssessmentType;
use App\Models\Subject;
use Illuminate\Http\Request;

class AssessmentTypeController extends Controller
{
    public function __construct()
    {
        // Only SchoolAdmin can define grading structure
        $this->middleware(['auth','role:SchoolAdmin']);
    }

    /**
     * Show assessment types.
     */
    public function index()
    {
        $types = AssessmentType::with('subject')
            ->where('school_id', session('active_school'))
            ->get();

        return view('assessments.index', compact('types'));
    }

    /**
     * Show form to create assessment type.
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('assessments.create', compact('subjects'));
    }

    /**
     * Store assessment type and validate total = 100%.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'weight'=>'required|integer|min:1|max:100',
            'subject_id'=>'required',
        ]);

        // Check current total weight for this subject
        $currentTotal = AssessmentType::where('subject_id', $request->subject_id)
            ->where('school_id', session('active_school'))
            ->sum('weight');

        if ($currentTotal + $request->weight > 100) {
            return back()->withErrors('Total assessment weight cannot exceed 100%.');
        }

        AssessmentType::create([
            'name'=>$request->name,
            'weight'=>$request->weight,
            'subject_id'=>$request->subject_id,
            'school_id'=>session('active_school'),
        ]);

        return redirect()->route('assessments.index')->with('success','Assessment type added.');
    }
}
