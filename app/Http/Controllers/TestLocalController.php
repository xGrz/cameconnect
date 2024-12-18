<?php

namespace App\Http\Controllers;

use App\Services\ConnectService;

class TestLocalController extends Controller
{
    public function __invoke()
    {
        auth()->loginUsingId(2);
        dump(
            ConnectService::make()->getTree(true),
        );

        return 'Success';
    }
}
