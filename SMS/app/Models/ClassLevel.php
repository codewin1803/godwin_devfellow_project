<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SchoolScope;

class ClassLevel extends Model
{
    use SchoolScope;

    protected $fillable = [
        'name',
        'school_id',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
