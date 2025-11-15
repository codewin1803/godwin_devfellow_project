<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class_level_id',
        'section_id',
        'school_id',
    ];

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }
}
