<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('products', ProductController::class);

// Route::get('cart', [mycontroller::class, 'cart'])->name('cart');
// Route::get('add-to-cart/{id}', [mycontroller::class, 'addToCart'])->name('add.to.cart');

// Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
// Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

// Route::get('login', [SessionsController::class, 'create'])->middleware('guest');
// Route::post('login', [SessionsController::class, 'store'])->middleware('guest');

// Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');