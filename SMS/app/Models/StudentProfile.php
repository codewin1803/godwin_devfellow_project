<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SchoolScope;

class StudentProfile extends Model
{
    use SchoolScope;

    protected $fillable = [
        'user_id',
        'admission_no',
        'date_of_birth',
        'gender',
        'class_level_id',
        'section_id',
        'school_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }

    public function parents()
    {
        return $this->belongsToMany(ParentProfile::class, 'parent_student', 'student_profile_id', 'parent_profile_id');
    }
}
