<?php

namespace App\Http\Controllers;

use App\Services\ConnectService;
use Inertia\Inertia;

class UserDashboardController extends Controller
{
    public function __invoke()
    {

        return Inertia::render('User/Dashboard', [
            'commands' => []
        ]);
    }
}
