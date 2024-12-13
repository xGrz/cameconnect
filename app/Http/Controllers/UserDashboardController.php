<?php

namespace App\Http\Controllers;

use App\Services\Connect;
use Inertia\Inertia;

class UserDashboardController extends Controller
{
    public function __invoke()
    {
        $service = Connect::withSites();

        return Inertia::render('User/Dashboard', [
            'siteList' => $service->getSitesTree(),
        ]);
    }
}
