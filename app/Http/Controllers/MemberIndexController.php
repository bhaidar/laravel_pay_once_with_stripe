<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfNotMember;
use Inertia\Inertia;

class MemberIndexController extends Controller
{
    public function __construct()
    {
        //$this->middleware([RedirectIfNotMember::class]);
    }

    public function __invoke()
    {
        return Inertia::render('Members/Index');
    }
}
