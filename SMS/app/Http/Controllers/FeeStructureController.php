<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:SchoolAdmin']);
    }

    // Show fee structures
    public function index()
    {
        $structures = FeeStructure::with(['category'])
            ->where('school_id', session('active_school'))
            ->get();

        return view('fees.structures.index', compact('structures'));
    }

    // Store fee structure
    public function store(Request $request)
    {
        $request->validate([
            'fee_category_id'=>'required',
            'class_level_id'=>'required',
            'term_id'=>'required',
            'amount'=>'required|numeric'
        ]);

        FeeStructure::create([
            ...$request->only(['fee_category_id','class_level_id','term_id','amount']),
            'school_id'=>session('active_school')
        ]);

        return back()->with('success','Fee structure saved');
    }
}



