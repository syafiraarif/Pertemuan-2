<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\AuthApiController; // Pastikan ini AuthApiController, bukan AuthController

// Endpoint untuk dapatkan Token
Route::post('/login', [AuthApiController::class, 'getToken']);

// Middleware sanctum untuk memastikan user bawa token saat CRUD
Route::middleware('auth:sanctum')->group(function () {
    
    // API Product
    Route::apiResource('product', ProductApiController::class);

    // API Kategori
    Route::apiResource('category', CategoryApiController::class);
    
});