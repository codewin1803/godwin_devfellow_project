<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeCategory extends Model
{
    protected $fillable = ['name', 'school_id'];

    public function structures()
    {
        return $this->hasMany(FeeStructure::class);
    }
}


