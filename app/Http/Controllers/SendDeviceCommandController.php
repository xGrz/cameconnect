<?php

namespace App\Http\Controllers;

use App\Services\CameConnect;

class SendDeviceCommandController extends Controller
{
    public function __invoke(int $device, int $command)
    {
        $status = CameConnect::make(auth()->user())->sendDeviceCommand($device, $command)->Success;
        return back();
    }
}
