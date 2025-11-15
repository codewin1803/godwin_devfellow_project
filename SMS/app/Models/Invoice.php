<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'term_id',
        'total_amount',
        'amount_paid',
        'balance',
        'status',
        'school_id',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}

}
