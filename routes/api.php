<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route::get('products', [ProductController::class, 'index']);
// Route::get('product/{id}/show', [ProductController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('product', [ProductController::class, 'store']);
    Route::put('product/{id}', [ProductController::class, 'update']);
    Route::delete('product/{id}', [ProductController::class, 'destroy']);

    Route::get('product/{id}', [ProductController::class, 'show']);
    Route::get('products', [ProductController::class, 'index']);

    Route::post('logout', [AuthController::class, 'logout']);
});