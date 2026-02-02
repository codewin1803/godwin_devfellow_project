<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SchoolScope;

class ClassroomAssignment extends Model
{
    use SchoolScope;

    protected $fillable = [
        'teacher_profile_id',
        'class_level_id',
        'section_id',
        'subject_id',
        'school_id',
    ];

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

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
