<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'class_level_id', 'subject_id', 'school_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(TeacherProfile::class);
    }

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

