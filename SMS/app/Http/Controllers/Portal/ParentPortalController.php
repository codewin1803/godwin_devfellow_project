<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Invoice;

class ParentPortalController extends Controller
{
    public function dashboard()
    {
        $parent = auth()->user()->parentProfile;
        $students = $parent->students;

        return view('portal.parent.dashboard', compact('parent', 'students'));
    }
}
