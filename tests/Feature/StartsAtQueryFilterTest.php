<?php

use App\Http\QueryFilters\CourseStartsThisWeekQueryFilter;
use App\Models\Course;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('apply_starts_at_query_filter', function () {
    // arrange
    $courses = Course::factory()
    ->count(2)
    ->state(new Sequence(
        ['starts_at' => '2022-04-01'],
        ['starts_at' => '2022-06-01'],
    ))
    ->create();

    // act
    // mock $next(): A function with parameter that returns the parameter
    // We want to return the query when calling $next($query)
    // therefore, we can mock $next() by passing an argument and returning the same argument
    $filter = new CourseStartsThisWeekQueryFilter();
    $filtered = $filter->handle(Course::query()->latest(), fn ($builder) => $builder, '2022-06-01');

    // assert
    expect($filtered->count())->toBe(1);
});
