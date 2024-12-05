<?php

namespace App\Http\Controllers;

use App\Enums\IODeviceCommand;
use App\Models\User;
use App\Services\ConnectService;

class OpenMyGateController extends Controller
{
    public function __invoke()
    {
        return ConnectService::make(User::first())->sendCommand(98101, IODeviceCommand::CLICK->value);
    }
}
