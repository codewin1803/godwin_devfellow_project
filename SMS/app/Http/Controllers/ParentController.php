<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Parent']);
    }

    public function dashboard()
    {
        return view('parent.dashboard');
    }
}
