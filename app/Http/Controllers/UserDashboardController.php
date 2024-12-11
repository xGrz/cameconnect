<?php

namespace App\Http\Controllers;

use App\Services\CameConnect;
use Inertia\Inertia;

class UserDashboardController extends Controller
{
    public function __invoke()
    {


        $service = CameConnect::make(auth()->user());
        $siteList = $service->getSites();

        return Inertia::render('User/Dashboard', [
            'siteList' => $siteList,

        ]);
    }
}
