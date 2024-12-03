<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $service = new \App\Services\ConnectService();
    dd($service);
    return view('welcome');
});
