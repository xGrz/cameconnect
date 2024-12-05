<?php

use App\Http\Controllers\Api\v1\ExecuteDeviceCommandController;
use App\Http\Controllers\Api\v1\GetDeviceStatusController;
use App\Http\Controllers\Api\v1\SyncAccountController;
use Illuminate\Support\Facades\Route;


Route::prefix('account')
    ->name('account.')
    ->group(function () {
        Route::get('sync', SyncAccountController::class)->name('sync');
    });

Route::post('open-my-gate', \App\Http\Controllers\OpenMyGateController::class)->name('openMyGate');

Route::prefix('device')
    ->name('device.')
    ->group(function () {

        Route::name('status')
            ->get('status', GetDeviceStatusController::class);

        Route::name('command.')
            ->prefix('command')
            ->group(function () {
                Route::get('open-gate', ExecuteDeviceCommandController::class)->name('open_gate');
            });

    });





