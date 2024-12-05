<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ConnectService;

class ExecuteDeviceCommandController extends Controller
{
    public function __invoke()
    {

        $command = ConnectService::make(User::first())
            ->sendCommand(237891, 2);
        return response()->json($command);
    }
}
