<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\AcademicSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermController extends Controller
{
    public function index()
    {
        $activeSession = AcademicSession::active()
            ->where('school_id', Auth::user()->school_id)
            ->first();

        $terms = Term::where('school_id', Auth::user()->school_id)->get();

        return view('terms.index', compact('terms', 'activeSession'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'academic_session_id' => 'required|exists:academic_sessions,id'
        ]);

        Term::create([
            'name' => $request->name,
            'academic_session_id' => $request->academic_session_id,
            'school_id' => Auth::user()->school_id,
        ]);

        return back()->with('success', 'Term created');
    }

    public function activate(Term $term)
    {
        if ($term->school_id !== Auth::user()->school_id) abort(403);

        Term::where('academic_session_id', $term->academic_session_id)
            ->update(['is_active' => false]);

        $term->update(['is_active' => true]);

        return back()->with('success', 'Term activated');
    }
}
