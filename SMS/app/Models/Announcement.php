<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'target_role', // 'admin', 'teacher', 'student', 'all'
        'publish_at',
        'expires_at',
        'school_id'
    ];

    protected $dates = ['publish_at', 'expires_at'];
}
