<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_profile_id',
        'teacher_profile_id',
        'date',
        'status',
        'note',
        'class_level_id',
        'section_id',
        'school_id',
    ];

    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_profile_id');
    }

    public function teacher()
    {
        return $this->belongsTo(TeacherProfile::class, 'teacher_profile_id');
    }

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
