<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TemperatureController;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'api.token'], function() {
    Route::get('/temperatures', [TemperatureController::class, 'getDailyTemperatures']);
});