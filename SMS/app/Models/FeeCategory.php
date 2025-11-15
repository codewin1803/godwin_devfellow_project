<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_optional',
        'school_id',
    ];

    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class);
    }
}
