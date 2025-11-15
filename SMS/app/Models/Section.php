<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class_level_id',
        'school_id',
    ];

    // Each section belongs to one class level
    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }
}
