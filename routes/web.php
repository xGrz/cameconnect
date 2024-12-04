<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'came-connect-overlay';
    return \App\Services\ConnectService::make(\App\Models\User::first())->sendCommand(98101, 2);
});

Route::get('open-gate', function () {
    return \App\Services\ConnectService::make(\App\Models\User::first())->sendCommand(98101, 2);
});
