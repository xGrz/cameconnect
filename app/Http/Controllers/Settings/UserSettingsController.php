<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\CameConnect;
use Inertia\Inertia;

class UserSettingsController extends Controller
{
    public function __invoke()
    {
        CameConnect::make()->getSites(false);
        return Inertia::render('Settings/UserSettings');
    }
}
