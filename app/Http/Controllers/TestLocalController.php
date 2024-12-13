<?php

namespace App\Http\Controllers;

use App\Services\Connect;

class TestLocalController extends Controller
{
    public function __invoke()
    {
        if (!auth()->check()) {
            auth()->loginUsingId(1);
        }
        $service = Connect::getSitesTree();

        dump(
            $service,
        );

        return 'Success';
    }
}
