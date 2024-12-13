<?php

namespace App\Http\Controllers;

use App\Services\CameConnect;

class SendDeviceCommandController extends Controller
{
    public function __invoke(int $deviceId, int $commandId, bool $isAutomation)
    {
        $status = $isAutomation
            ? CameConnect::make(auth()->user())->sendAutomationCommand($deviceId, $commandId)->Success
            : CameConnect::make(auth()->user())->sendDeviceCommand($deviceId, $commandId)->Success;
    }
}
