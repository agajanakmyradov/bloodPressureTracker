<?php

use App\Http\Controllers\Api\MeasurementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test',  function (Request $request) {
    return 'test';
})->middleware('auth:sanctum');

Route::apiResource('bp', MeasurementController::class)->middleware('auth:sanctum');
