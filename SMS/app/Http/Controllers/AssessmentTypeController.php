<?php

namespace App\Http\Controllers;

use App\Models\AssessmentType;
use App\Models\Subject;
use Illuminate\Http\Request;

class AssessmentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']); // Only admins
    }

    // List assessment types per subject
    public function index($subject_id)
    {
        $subject = Subject::findOrFail($subject_id);
        $assessments = $subject->assessmentTypes;
        return view('assessments.index', compact('subject', 'assessments'));
    }

    // Show form for creating new assessment type
    public function create($subject_id)
    {
        $subject = Subject::findOrFail($subject_id);
        return view('assessments.create', compact('subject'));
    }

    // Store new assessment type
    public function store(Request $request, $subject_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|integer|min:1|max:100',
        ]);

        $subject = Subject::findOrFail($subject_id);

        // Validate total weight
        $totalWeight = $subject->assessmentTypes()->sum('weight') + $request->weight;
        if ($totalWeight > 100) {
            return redirect()->back()->withErrors(['weight' => 'Total weight exceeds 100%']);
        }

        $subject->assessmentTypes()->create([
            'name' => $request->name,
            'weight' => $request->weight,
        ]);

        return redirect()->route('assessments.index', $subject_id)
                         ->with('success', 'Assessment type added.');
    }

    // Edit form
    public function edit($subject_id, AssessmentType $assessmentType)
    {
        $subject = Subject::findOrFail($subject_id);
        return view('assessments.edit', compact('subject', 'assessmentType'));
    }

    // Update assessment type
    public function update(Request $request, $subject_id, AssessmentType $assessmentType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|integer|min:1|max:100',
        ]);

        $subject = Subject::findOrFail($subject_id);

        // Validate total weight excluding current record
        $totalWeight = $subject->assessmentTypes()
                               ->where('id', '!=', $assessmentType->id)
                               ->sum('weight') + $request->weight;

        if ($totalWeight > 100) {
            return redirect()->back()->withErrors(['weight' => 'Total weight exceeds 100%']);
        }

        $assessmentType->update([
            'name' => $request->name,
            'weight' => $request->weight,
        ]);

        return redirect()->route('assessments.index', $subject_id)
                         ->with('success', 'Assessment type updated.');
    }

    // Delete assessment type
    public function destroy($subject_id, AssessmentType $assessmentType)
    {
        $assessmentType->delete();
        return redirect()->route('assessments.index', $subject_id)
                         ->with('success', 'Assessment type deleted.');
    }
}
