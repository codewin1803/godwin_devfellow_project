<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SchoolScope;

class Section extends Model
{
    use SchoolScope;

    protected $fillable = [
        'name',
        'class_level_id',
        'school_id',
    ];

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }
}
