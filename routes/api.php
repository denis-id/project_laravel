<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// register & login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/webhook', [OrderController::class, 'webhookPayment']);

// order (pakai sanctum)
Route::middleware("auth:sanctum")->group(function () {
    Route::post('/orders', [OrderController::class, 'createOrder']);
    Route::get('/orders', [OrderController::class, 'getOrders']);
    Route::get('/orders/{id}/pay', [OrderController::class, 'payOrder']);
});