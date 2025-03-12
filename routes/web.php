<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::resource('users', UserController::class);
    Route::get('/products/{id}/download-pdf', [ProductController::class, 'downloadPdf'])->name('products.downloadPdf');    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', [AuthController::class, 'index'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");