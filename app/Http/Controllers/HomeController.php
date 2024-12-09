<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ConnectService;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Home', [
            'sites' => ConnectService::make(User::first())->sites(),
        ]);
    }
}
