<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_profile_id',
        'assessment_type_id',
        'score',
        'is_locked',
        'school_id',
    ];
}
