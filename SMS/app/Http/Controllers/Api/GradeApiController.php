<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeApiController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Grade::with(['student', 'subject', 'term'])->get()
        );
    }
}
