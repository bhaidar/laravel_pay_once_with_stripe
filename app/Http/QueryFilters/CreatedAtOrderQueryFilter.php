<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class CreatedAtOrderQueryFilter
{
    public function handle(Builder $query, $next, $value)
    {
        if (! $value) {
            return $next($query);
        }

        return $next($query)
            ->reorder()
            ->orderBy('created_at', $value);
    }
}
