<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductVariantController;
use App\Http\Controllers\API\ChatbotController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/webhook', [OrderController::class, 'webhookPayment']);

// Product routes
Route::resource('products', ProductController::class);

// Product Variant routes
Route::resource('product-variants', ProductVariantController::class);

// Category routes
Route::get('/categories', [CategoryController::class, 'getCategory']);

// Article routes
Route::get('/articles', [ArticleController::class, 'getArticle']);
Route::get('/articles/{slug}', [ArticleController::class, 'getArticleBySlug']);
Route::get('/detail/{slug}', [ArticleController::class, 'articleDetail']);
Route::post('/articles', [ArticleController::class, 'createArticle']);
Route::get('/featured', [ArticleController::class, 'featuredArticle']);
Route::get('articles/related/{id}', [ArticleController::class, 'getRelatedArticles']);

// Order routes (protected by Sanctum middleware)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderController::class, 'getOrders']);  
    Route::get('/orders/{id}', [OrderController::class, 'getOrderById']);
    Route::post('/orders', [OrderController::class, 'createOrder']);
    Route::get('/orders/{id}/pay', [OrderController::class, 'payOrder']);
    Route::delete('/orders/{id}', [OrderController::class, 'deleteOrder']);
});
Route::post('/chatbot', [ChatbotController::class, 'chat']);