<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Announcement extends Model
{
    protected $fillable = [
        'school_id',
        'title',
        'body',
        'target_roles',
        'publish_at',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'target_roles' => 'array',
        'publish_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::addGlobalScope('school', function (Builder $builder) {
            if (session()->has('active_school')) {
                $builder->where('school_id', session('active_school'));
            }
        });
    }

    public function scopeActive($query)
    {
        return $query
            ->where('publish_at', '<=', Carbon::now())
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', Carbon::now());
            });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
