<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('product/{id}', [ProductController::class, 'show']);
    Route::get('products', [ProductController::class, 'index']);

    Route::middleware(RoleMiddleware::class . ':superadmin')->group(function () {
        Route::post('product', [ProductController::class, 'store']);
        Route::put('product/{id}', [ProductController::class, 'update']);
        Route::delete('product/{id}', [ProductController::class, 'destroy']);
    });

    Route::middleware(RoleMiddleware::class . ':admin,superadmin')->group(function () {
        Route::post('product', [ProductController::class, 'store']);
        Route::put('product/{id}', [ProductController::class, 'update']);
    });

    Route::post('logout', [AuthController::class, 'logout']);
});