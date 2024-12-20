<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Services\ConnectService;

class SendDeviceCommandController extends Controller
{
    public function __invoke(Command $command)
    {
        $command->loadMissing(['device.site.users' => fn($query) => $query->where('id', auth()->id())]);
        $user = $command->device?->site?->users?->first();
        ConnectService::make($user)->sendCommand($command->device, $command->command);
    }
}
