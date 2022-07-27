<?php

namespace App\Http\Controllers;

use App\Models\Course;
use CourseStartsThisWeek;
use Illuminate\Pipeline\Pipeline;
use Inertia\Inertia;

class MemberIndexController extends Controller
{
    public function __invoke()
    {
        $courses = app(Pipeline::class)
        ->send(Course::latest())
        ->through([
            CourseStartsThisWeek::class,
        ])
        ->get();

        return Inertia::render('Members/Index', ['courses' => $courses]);
    }
}
