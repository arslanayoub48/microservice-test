<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

// User Authentication Routes

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected Routes with Role Middleware
Route::middleware(['auth:api'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    // Product Management Routes with Role Permissions
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::get('products', [ProductController::class, 'index']);
        Route::post('products', [ProductController::class, 'store']);
        Route::put('products/{id}', [ProductController::class, 'update']);
        Route::delete('products/{id}', [ProductController::class, 'destroy']);
    });

    // User can only view products
    Route::middleware(['role:user'])->group(function () {
        Route::get('products', [ProductController::class, 'index']);
    });
});

