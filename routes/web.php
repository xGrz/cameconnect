<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {


    $token = cache()->remember('token', 7200, function () {
        return \App\Services\ConnectLoginService::login(
            config('cameconnect.username'),
            config('cameconnect.password'),
        )->getBearer();
    });


    return \App\Services\ConnectService::make($token)->devices();
});
