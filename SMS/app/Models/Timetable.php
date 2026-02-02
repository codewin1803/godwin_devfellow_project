<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'class_level_id',
        'section_id',
        'subject_id',
        'teacher_profile_id',
        'weekday',
        'start_time',
        'end_time',
        'school_id',
    ];

    // Relationships

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(TeacherProfile::class, 'teacher_profile_id');
    }
}
