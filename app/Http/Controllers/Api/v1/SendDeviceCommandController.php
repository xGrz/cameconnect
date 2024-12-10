<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CameConnect;

class SendDeviceCommandController extends Controller
{
    public function __invoke(int $device, int $command)
    {
        $status = CameConnect::make(User::first())->sendDeviceCommand($device, $command)->Success;
        $status = CameConnect::make(User::first())->sendAutomationCommand($device, $command)->Success;

        return $status
            ? response(['status' => true], 201)
            : response(['status' => false], 403);
    }
}
