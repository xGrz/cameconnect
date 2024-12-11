<?php

use App\Http\Controllers\Auth\AuthenticateSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestLocalController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {

    Route::get('/', HomeController::class)->name('home');
    Route::post('auth/login', [AuthenticateSessionController::class, 'store'])->name('login');

});


Route::middleware('auth')->group(function () {

    Route::get('dashboard', UserDashboardController::class)->name('dashboard');


//    Route::post('logout', [AuthenticateSessionController::class, 'destroy'])
//        ->name('logout');
});


if (app()->environment('local')) {
    Route::get('test', TestLocalController::class)->name('test');
}
