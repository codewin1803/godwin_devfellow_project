<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'school_id',
        'class_level_id',
        'subject_id',
        'teacher_id',
        'weekday',
        'start_time',
        'end_time',
    ];

    public function classLevel() {
        return $this->belongsTo(ClassLevel::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
