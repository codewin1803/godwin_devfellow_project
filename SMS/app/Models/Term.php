<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'name',
        'is_active',
        'academic_session_id',
        'school_id'
    ];

    public function session()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
