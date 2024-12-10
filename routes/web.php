<?php

use App\Http\Controllers\Auth\AuthenticateSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestLocalController;
use Illuminate\Support\Facades\Route;



Route::middleware([])->group(function () {

    Route::get('/', HomeController::class)->name('home');

//    Route::get('login', [AuthenticateSessionController::class, 'create'])
//        ->name('login');
//
    Route::post('login', [AuthenticateSessionController::class, 'store'])->name('login');
});


Route::middleware('auth')->group(function () {
//    Route::post('logout', [AuthenticateSessionController::class, 'destroy'])
//        ->name('logout');
});








if (app()->environment('local')) {
    Route::get('test', TestLocalController::class)->name('test');
}
