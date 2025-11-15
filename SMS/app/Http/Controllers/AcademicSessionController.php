<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademicSessionController extends Controller
{
    public function index()
    {
        $sessions = AcademicSession::where('school_id', Auth::user()->school_id)->get();
        return view('sessions.index', compact('sessions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        AcademicSession::create([
            'name' => $request->name,
            'school_id' => Auth::user()->school_id
        ]);

        return back()->with('success', 'Session created');
    }

    public function activate(AcademicSession $session)
    {
        if ($session->school_id !== Auth::user()->school_id) abort(403);

        AcademicSession::where('school_id', Auth::user()->school_id)->update(['is_active' => false]);

        $session->update(['is_active' => true]);

        return back()->with('success', 'Academic session activated');
    }
}
