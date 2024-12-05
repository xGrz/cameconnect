<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class ExecuteDeviceCommandController extends Controller
{
    public function __invoke()
    {
        return \App\Services\ConnectService::make(\App\Models\User::first())
            ->sendCommand(98101, 2);
    }
}
