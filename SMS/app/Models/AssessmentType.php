<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentType extends Model
{
    protected $fillable = [
        'name',
        'weight',
        'subject_id',
        'school_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
