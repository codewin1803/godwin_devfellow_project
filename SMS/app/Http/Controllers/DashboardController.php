<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('SuperAdmin')) {
            // 1. Fetch counts for the KPI cards
            $schools = School::count();
            $students = StudentProfile::count();
            
            $teachers = class_exists('App\Models\TeacherProfile') 
                ? TeacherProfile::count() 
                : 0;

            // 2. Financial Logic
            $revenue = 0; 

            // 3.
            // Sending an empty collection allows ->keys() and ->values() to work
            $monthlyRevenue = collect(); 

            return view('dashboard.superadmin', compact(
                'schools', 
                'students', 
                'teachers', 
                'revenue',
                'monthlyRevenue'
            ));
        }

        if ($user->hasRole('SchoolAdmin')) {
            return view('dashboard.schooladmin');
        }

        /**
         * FALLBACK
         * If no roles match, show schooladmin instead of a blank page or error.
         */
        return view('dashboard.schooladmin');
    }
}
