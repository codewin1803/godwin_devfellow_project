<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:SchoolAdmin']);
    }

    public function dashboard()
    {
        return view('schooladmin.dashboard');
    }
}
