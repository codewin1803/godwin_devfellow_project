<?php

namespace App\Http\Controllers;

use App\Models\FeeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import Auth facade

class FeeCategoryController extends Controller
{
    public function index()
    {
        $categories = FeeCategory::where('school_id', Auth::user()->school_id) // <-- replaced
            ->get();

        return view('fees.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('fees.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        FeeCategory::create([
            'name' => $request->name,
            'school_id' => Auth::user()->school_id, // <-- replaced
        ]);

        return redirect()->route('fee-categories.index')->with('success', 'Fee category created.');
    }

    public function destroy($id)
    {
        FeeCategory::findOrFail($id)->delete();
        return back()->with('success', 'Fee category deleted.');
    }
}
