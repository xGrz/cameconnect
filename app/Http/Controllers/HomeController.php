<?php

namespace App\Http\Controllers;

use App\Services\CameConnect;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
//        $service = CameConnect::make(auth()->user());
//        $siteList = $service->getSites();
////        dd($siteList);
////        dd(
////            $siteList,
////            $siteList->first()->deviceIds->toArray(),
////            $service->deviceCommands(237891)->toArray(),
////            $service->deviceCommands(237893)->toArray(),
////            $service->deviceCommands(98101)->toArray(),
////            $service->deviceCommands(98102)->toArray(),
////            $service->deviceCommands(98104)->toArray(),
////            $service->deviceCommands(98105)->toArray(),
////        );
//
//
//        return Inertia::render('Dashboard', [
//            'siteList' => $siteList,
//        ]);

        return Inertia::render('Index', []);
    }
}




