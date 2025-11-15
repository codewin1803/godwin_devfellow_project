<?php

use Illuminate\Support\Facades\Auth;
use App\Models\AcademicSession;
use App\Models\Term;

function activeSessionId() {
    return Auth::user()?->school?->active_session_id;
}

function activeTermId() {
    return Auth::user()?->school?->active_term_id;
}

