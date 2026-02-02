<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FeeStructure extends Model
{
    protected $fillable = [
        'fee_category_id',
        'class_level_id',
        'term_id',
        'amount',
        'school_id'
    ];

    public function category()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id');
    }
}



