<?php

use Illuminate\Database\Eloquent\Builder;

class CourseStartsThisWeek
{
    public function handle(Builder $query, $next)
    {
        return $next($query);
    }
}
