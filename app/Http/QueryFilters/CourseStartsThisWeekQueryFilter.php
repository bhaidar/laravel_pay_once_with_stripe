<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class CourseStartsThisWeekQueryFilter
{
    public function handle(Builder $query, $next, $value)
    {
        if (! $value) {
            return $next($query);
        }

        return $next($query)
            ->whereDate('starts_at', '>=', $value);
    }
}
