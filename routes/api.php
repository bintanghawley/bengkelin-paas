<?php

use App\Http\Controllers\Api\OilController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SparepartController;
use App\Http\Controllers\Api\TireController;
use Illuminate\Support\Facades\Route;

Route::apiResource('services', ServiceController::class)->only(['index', 'show']);
Route::apiResource('tires', TireController::class)->only(['index', 'show']);
Route::apiResource('oils', OilController::class)->only(['index', 'show']);
Route::apiResource('spareparts', SparepartController::class)->only(['index', 'show']);
