<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SchoolScope
{
    protected static function bootSchoolScope()
    {
        static::addGlobalScope('school', function (Builder $builder) {
            if (session()->has('active_school')) {
                $builder->where('school_id', session('active_school'));
            }
        });
    }
}
