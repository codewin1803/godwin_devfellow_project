<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    protected $fillable = [
        'name',
        'is_active',
        'school_id'
    ];

    public function terms()
    {
        return $this->hasMany(Term::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
