<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admission_no',
        'class_level_id',
        'section_id',
        'school_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function parents()
    {
        return $this->belongsToMany(ParentProfile::class, 'parent_student', 'student_id', 'parent_id');
    }

    // 🔹 A student has many grades
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    // 🔹 Accessor for full name
    public function getFullNameAttribute()
    {
        if ($this->user) {
            return $this->user->first_name . ' ' . $this->user->last_name;
        }

        return '';
    }

    // 🔹 Useful for report card — example: "JSS 2 - A"
    public function getClassroomNameAttribute()
    {
        $level = $this->classLevel ? $this->classLevel->name : '';
        $section = $this->section ? $this->section->name : '';
        return trim($level . ' ' . $section);
    }
}
