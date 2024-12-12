<?php

namespace App\Http\Controllers;

use App\Services\Connect;

class TestLocalController extends Controller
{
    public function __invoke()
    {
        $service = Connect::withSites()->withStates();

        dump(
            $service->getSiteList()->first(),
        );

        return 'Success';
    }
}
