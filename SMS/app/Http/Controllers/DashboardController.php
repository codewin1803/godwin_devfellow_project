<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('SuperAdmin')) {
            return view('dashboard.superadmin');
        }

        if ($user->hasRole('SchoolAdmin')) {
            return view('dashboard.schooladmin');
        }

        if ($user->hasRole('Teacher')) {
            return view('dashboard.teacher');
        }

        if ($user->hasRole('Bursar')) {
            return view('dashboard.bursar');
        }

        return view('dashboard.default');
    }
}
