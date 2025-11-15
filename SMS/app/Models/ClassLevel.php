<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'school_id',
    ];

    // A class level has many sections
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
