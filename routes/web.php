<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {



    return \App\Services\ConnectService::make(\App\Models\User::first())->sync()->sites();
});
