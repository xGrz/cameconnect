<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ConnectService;

class GetDeviceStatusController extends Controller
{
    public function __invoke()
    {
         $status = ConnectService::make(User::first())
            ->deviceStatus(237891);
         return $status;
    }
}
