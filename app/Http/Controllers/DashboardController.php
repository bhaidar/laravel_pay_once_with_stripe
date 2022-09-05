<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        \Log::info('Dashboard');

        Debugbar::info('Dashboard!');

        return Inertia::render('Dashboard', ['status' => session('status')]);
    }
}
