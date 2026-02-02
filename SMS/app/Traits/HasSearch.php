<?php

namespace App\Traits;

trait HasSearch
{
    public function scopeSearch($query, $term, array $columns)
    {
        if (!$term) return $query;

        return $query->where(function ($q) use ($term, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$term}%");
            }
        });
    }
}
