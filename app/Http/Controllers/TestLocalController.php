<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CameConnect;

class TestLocalController extends Controller
{
    public function __invoke()
    {
        $user = User::first();
        $c = CameConnect::make($user)->getSites();
        dd($c);
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
