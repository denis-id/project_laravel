<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::prefix("admin")->group(function () {
  Route::get('/admin', DashboardController::class)->name('dashboard');
  Route::resource('categories', CategoryController::class);
});