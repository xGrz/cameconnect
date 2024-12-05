<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');


if (app()->environment('local')) {
    Route::get('test', \App\Http\Controllers\TestLocalController::class)->name('test');
}
