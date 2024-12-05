<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ConnectService;

class SyncAccountController extends Controller
{
    public function __invoke()
    {
        ConnectService::make(User::first())->sync();

        return response('', 201);
    }
}
