<?php

use App\Http\Controllers\Api\MeasurementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/auth-test',  function (Request $request) {
    return true;
})->middleware('auth:sanctum');

Route::get('/bp/getmonths', [MeasurementController::class, 'getMonths'])->middleware('auth:sanctum')->name('bp.months');

Route::apiResource('bp', MeasurementController::class)->middleware('auth:sanctum');



