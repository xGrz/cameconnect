<?php

namespace App\Http\Controllers;

use App\Enums\IODeviceCommand;
use App\Models\User;
use App\Services\ConnectService;
use Illuminate\Http\Request;

class OpenMyGateController extends Controller
{
    public function __invoke(Request $request)
    {

        if (empty(config('cameconnect.myGateToken'))) return response('AppConfig missing', 401);
        if (!$request->hasHeader('Token')) return response('Not Found', 404);
        if ($request->header('Token') !== 'Bearer ' . config('cameconnect.myGateToken')) return response('Unauthorized', 401);

        return ConnectService::make(User::first())->sendCommand(98101, IODeviceCommand::CLICK->value);
    }
}
