<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', DashboardController::class)->name("dashboard");

Route::get('login',  function () {
  return view('login.index');
})->name('login');
