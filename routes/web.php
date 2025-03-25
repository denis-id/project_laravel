<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::get("/", function() {
    return redirect("/admin");
});

// Rute untuk admin, dengan prefix 'admin' dan middleware 'auth'
Route::prefix('admin')->middleware('auth')->group(function () {
    // Dashboard utama
    Route::get('/', DashboardController::class)->name('dashboard');

    // Rute untuk kategori, produk, artikel, dan pengguna
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);

    // Menampilkan dan mengelola pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Rute untuk artikel
    Route::resource('articles', ArticleController::class); // Menggunakan resource untuk artikel

    // Menyediakan fitur download PDF untuk produk
    Route::get('/products/{id}/download-pdf', [ProductController::class, 'downloadPdf'])->name('products.downloadPdf');    

    // Rute untuk logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Rute untuk login dan lupa password
Route::get('/login', [AuthController::class, 'index'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

// Rute untuk mengganti bahasa
Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");