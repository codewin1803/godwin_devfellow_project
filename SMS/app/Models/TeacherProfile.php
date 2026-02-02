<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SchoolScope;

class TeacherProfile extends Model
{
    use SchoolScope;

    protected $fillable = [
        'user_id',
        'employee_number',
        'phone',
        'address',
        'school_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(ClassroomAssignment::class);
    }
}
