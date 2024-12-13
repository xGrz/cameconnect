<?php

use App\Http\Controllers\Auth\AuthenticateSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SendDeviceCommandController;
use App\Http\Controllers\Settings\UserSettingsController;
use App\Http\Controllers\TestLocalController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {

    Route::get('/', HomeController::class)->name('home');
    Route::post('auth/login', [AuthenticateSessionController::class, 'store'])->name('login');

});


Route::middleware('auth')->group(function () {

    Route::get('dashboard', UserDashboardController::class)
        ->name('dashboard');

    Route::prefix('settings')
        ->name('settings.')
        ->group(function () {
            Route::get('index', UserSettingsController::class)
                ->name('index');

        });

    Route::delete('logout', [AuthenticateSessionController::class, 'destroy'])
        ->name('logout');


    Route::prefix('device')
        ->name('device.')
        ->group(function () {
            Route::post('{deviceId}/command/{commandId}/{isAutomation}', SendDeviceCommandController::class)->name('command');
        });
});


if (app()->environment('local')) {
    Route::get('test', TestLocalController::class)->name('test');
}
