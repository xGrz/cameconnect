<?php

namespace App\Http\Controllers;

use App\Services\Connect;
use Inertia\Inertia;

class UserSitesController extends Controller
{
    public function __invoke()
    {
        $service = Connect::withSites()->withStates();

        return Inertia::render('User/SitesTreeView', [
            'siteList' => $service->getSitesTree(),
        ]);
    }
}
