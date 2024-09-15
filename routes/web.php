<?php

use App\Http\Controllers\MeasurementController;
use Illuminate\Support\Facades\Route;

Route::view('/{any}', 'app')->where('any', '.*');

Auth::routes();


