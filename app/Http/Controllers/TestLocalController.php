<?php

namespace App\Http\Controllers;

use App\Actions\GetUserFavouriteCommandsAction;
use App\Models\Device;

class TestLocalController extends Controller
{
    public function __invoke()
    {
        auth()->loginUsingId(2);
        dd(
            (new GetUserFavouriteCommandsAction)->get()
        );

        return 'Success';
    }
}
