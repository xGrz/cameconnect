<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::name('command')
    ->prefix('command')
    ->group(function () {
        Route::post('open-gate', \App\Http\Controllers\Api\v1\ExecuteDeviceCommandController::class);
    });


