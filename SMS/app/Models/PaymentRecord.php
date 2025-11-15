<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'method',
        'reference',
        'school_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
