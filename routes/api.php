<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TemperatureController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App/Http/Controllers/Api/V1', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/temperatures', [TemperatureController::class, 'getDailyTemperatures']);
});

