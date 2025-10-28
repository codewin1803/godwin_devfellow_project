<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BursarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Bursar']);
    }

    public function dashboard()
    {
        return view('bursar.dashboard');
    }
}
