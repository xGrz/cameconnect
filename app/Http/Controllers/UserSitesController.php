<?php

namespace App\Http\Controllers;

use App\Services\Connect;
use Inertia\Inertia;

class UserSitesController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('User/SitesTreeView', [
            'siteList' => Connect::withSites()->withStates()->getSitesTree(),
        ]);
    }
}
