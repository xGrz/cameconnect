<?php

namespace App\Http\Controllers;

use App\Services\ConnectService;
use Inertia\Inertia;

class UserSitesController extends Controller
{
    public function __invoke()
    {
//        dd(ConnectService::make()->getTree());
        return Inertia::render('User/SitesTreeView', [
            'siteList' => ConnectService::make()->getTree(),
        ]);
    }
}
