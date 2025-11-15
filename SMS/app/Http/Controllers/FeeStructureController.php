<?php

namespace App\Http\Controllers;

use App\Models\FeeCategory;
use App\Models\FeeStructure;
use App\Models\ClassLevel;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- Import Auth facade

class FeeStructureController extends Controller
{
    public function index()
    {
        $structures = FeeStructure::with(['category', 'classLevel', 'term'])
            ->where('school_id', Auth::user()->school_id)
            ->get();

        return view('fees.structures.index', compact('structures'));
    }

    public function create()
    {
        $categories = FeeCategory::where('school_id', Auth::user()->school_id)->get();
        $classLevels = ClassLevel::where('school_id', Auth::user()->school_id)->get();
        $terms = Term::where('school_id', Auth::user()->school_id)->get();

        return view('fees.structures.create', compact('categories', 'classLevels', 'terms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fee_category_id' => 'required',
            'class_level_id' => 'required',
            'term_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        FeeStructure::create([
            'fee_category_id' => $request->fee_category_id,
            'class_level_id' => $request->class_level_id,
            'term_id' => $request->term_id,
            'amount' => $request->amount,
            'school_id' => Auth::user()->school_id,
        ]);

        return redirect()->route('fee-structures.index')->with('success', 'Fee structure added.');
    }

    public function destroy($id)
    {
        FeeStructure::findOrFail($id)->delete();
        return back()->with('success', 'Fee structure deleted.');
    }
}
