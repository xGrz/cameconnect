<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use App\Services\ConnectService;

class TestLocalController extends Controller
{
    public function __invoke()
    {
        $user = User::first();

        $c = ConnectService::make($user)->commands(237891);
        return $c;
//
//
//        $output = [];
//        foreach (Device::all() as $device) {
//            $output[] = ConnectService::make($user)->deviceStatus($device->id);
//        }
//
//        return $output;
    }
}
