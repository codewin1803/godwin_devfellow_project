<?php

namespace App\Http\Controllers;

use App\Models\FeeCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FeeCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:SchoolAdmin']);
    }

    // List fee categories
    public function index()
    {
        $categories = FeeCategory::where('school_id', session('active_school'))->get();
        return view('fees.categories.index', compact('categories'));
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate(['name'=>'required|string']);

        FeeCategory::create([
            'name'=>$request->name,
            'school_id'=>session('active_school')
        ]);

        return back()->with('success','Fee category added');
    }
}


