<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SchoolScope;

class Subject extends Model
{
    use SchoolScope;

    protected $fillable = [
        'name',
        'code',
        'school_id',
    ];
}
