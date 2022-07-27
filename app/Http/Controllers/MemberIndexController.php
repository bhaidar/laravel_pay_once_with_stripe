<?php

namespace App\Http\Controllers;

use App\Http\QueryFilters\CourseStartsThisWeekQueryFilter;
use App\Http\QueryFilters\CreatedAtOrderQueryFilter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Inertia\Inertia;

class MemberIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $courses = app(Pipeline::class)
        ->send(Course::latest())
        ->through([
            // Pipe is similar to a Middleware, you can pass arguments too
            // this way it's easier to test and not relying on global helper functions
            // https://darkghosthunter.medium.com/laravel-the-hidden-pipeline-part-2-2c837e17a41e
            CourseStartsThisWeekQueryFilter::class.':'.$request->get('starts_at'),
            CreatedAtOrderQueryFilter::class.':'.$request->get('created_at_order'),
        ])
        ->thenReturn()
        //->get(['id', 'name', 'starts_at']);
        ->get();

        return Inertia::render('Members/Index', ['courses' => $courses]);
    }
}
