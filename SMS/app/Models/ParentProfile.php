<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SchoolScope;

class ParentProfile extends Model
{
    use SchoolScope;

    protected $fillable = [
        'user_id',
        'relation',
        'phone',
        'address',
        'school_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->belongsToMany(StudentProfile::class, 'parent_student', 'parent_profile_id', 'student_profile_id');
    }
}
