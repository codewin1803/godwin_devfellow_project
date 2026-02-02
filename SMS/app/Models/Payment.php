<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'amount',
        'method',
        'reference',
        'paid_at',
        'created_by',
        'school_id'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}



