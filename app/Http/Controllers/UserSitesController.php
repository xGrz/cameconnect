<?php

namespace App\Http\Controllers;

use App\Services\ConnectService;
use Inertia\Inertia;

class UserSitesController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('User/SitesTreeView', [
            'siteList' => ConnectService::make()->getTree(true),
        ]);
    }
}
