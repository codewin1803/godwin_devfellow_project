<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'school_id',
    ];

    /**
     * Each subject belongs to a specific school.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * (Optional) A subject can be taught in many class levels.
     * Use if you plan to link subjects to class levels later.
     */
    public function classLevels()
    {
        return $this->belongsToMany(ClassLevel::class, 'class_level_subject');
    }
}
