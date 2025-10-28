<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Teacher']);
    }

    public function dashboard()
    {
        return view('teacher.dashboard');
    }
}
