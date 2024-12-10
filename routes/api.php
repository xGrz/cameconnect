<?php

use App\Http\Controllers\Api\v1\SendDeviceCommandController;
use App\Http\Controllers\Api\v1\SyncAccountController;
use App\Http\Controllers\OpenMyGateController;
use Illuminate\Support\Facades\Route;


Route::prefix('account')
    ->name('account.')
    ->group(function () {
        Route::get('sync', SyncAccountController::class)->name('sync');
    });

Route::post('open-my-gate', OpenMyGateController::class)->name('openMyGate');


Route::post('device/{device}/command/{command}', SendDeviceCommandController::class);

//
//Route::prefix('device')
//    ->name('device.')
//    ->group(function () {
//
//        Route::name('status')
//            ->get('status', GetDeviceStatusController::class);
//
//        Route::name('command.')
//            ->prefix('command')
//            ->group(function () {
//                Route::get('open-gate', ExecuteDeviceCommandController::class)->name('open_gate');
//            });
//
//    });
//
//
//
//
//
