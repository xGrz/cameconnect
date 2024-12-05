<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');

//Route::get('open-gate', function () {
//    return \App\Services\ConnectService::make(\App\Models\User::first())->sendCommand(98101, 2);
//});
