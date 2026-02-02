<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableApiController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Timetable::with(['classLevel', 'subject', 'teacher'])->get()
        );
    }
}
