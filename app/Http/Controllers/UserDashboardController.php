<?php

namespace App\Http\Controllers;

use App\Actions\GetUserFavouriteCommandsAction;
use Inertia\Inertia;

class UserDashboardController extends Controller
{
    public function __invoke()
    {

//        dd(
//            auth()->user()->favoritesCommandsByDevices()
//        );
        return Inertia::render('User/Dashboard', [
            'commands' => (new GetUserFavouriteCommandsAction())->get()
        ]);
    }
}
