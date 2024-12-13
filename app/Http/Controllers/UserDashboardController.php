<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class UserDashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('User/Dashboard');
    }
}
