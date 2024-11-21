<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderitemController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', [AuthController::class, 'login']);
Route::get('/restaurant/info/{id}', [RestaurantController::class, 'info']);

// php artisan install:api


Route::get('/restaurant', [OrderitemController::class, 'index']);
Route::get('/restaurant/show/{id}', [OrderitemController::class, 'show']);
Route::post('/restaurant/store', [OrderitemController::class, 'store']);
Route::put('/restaurant/update/{id}', [OrderitemController::class, 'update']);
Route::delete('/restaurant/delete/{id}', [OrderitemController::class, 'delete']);

