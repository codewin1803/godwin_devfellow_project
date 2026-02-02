<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $total_amount
 */

class Invoice extends Model
{
    protected $fillable = [
        'student_profile_id',
        'term_id',
        'total_amount',
        'status',
        'school_id'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}

public function getTotalPaidAttribute()
{
    return $this->payments()->sum('amount');
}

public function getBalanceAttribute()
{
    return $this->total_amount - $this->total_paid;
}

}

