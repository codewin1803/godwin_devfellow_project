<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller
{
    public function index()
    {
        $sessions = AcademicSession::all();
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|unique:academic_sessions,name',
        ]);

        AcademicSession::create([
            'name'=>$request->name,
            'school_id'=>session('active_school'),
        ]);

        return redirect()->route('sessions.index')->with('success','Academic session created');
    }

    public function activate(AcademicSession $session)
    {
        AcademicSession::where('school_id', session('active_school'))
            ->update(['is_active'=>false]);

        $session->update(['is_active'=>true]);

        return back()->with('success','Active session updated');
    }
}
