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

        if (!$request->hasHeader('Token')) return response('Not Found', 404);
        if ($request->header('Token') !== 'Bearer 03083fd7e1955492c23553a03784fb8c') return response('Unauthorized', 401);
        return ConnectService::make(User::first())->sendCommand(98101, IODeviceCommand::CLICK->value);
    }
}
