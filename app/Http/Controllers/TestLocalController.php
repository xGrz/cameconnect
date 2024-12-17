<?php

namespace App\Http\Controllers;

use App\Actions\SyncConnectAction;
use App\Actions\UserSitesWithDevicesAction;
use App\Services\Connect;

class TestLocalController extends Controller
{
    public function __invoke()
    {
        if (!auth()->check()) {
            auth()->loginUsingId(1);
        }

        dd(
            SyncConnectAction::make(),
//            UserSitesWithDevicesAction::getTree(false)
        );


        return 'Success';
        $service = Connect::getSitesTree();

        dump(
            $service,
        );

        return 'Success';
    }
}
