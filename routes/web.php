<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/app', [PageController::class, 'app']);


Route::get('/index', [PageController::class, 'index']);
Route::post('/index', [ProductController::class, 'add'])->name('index');

Route::get('/cart', [PageController::class, 'cart']);
Route::post('/cart', [ProductController::class, 'remove']);
Route::post('/cart/order', [OrderController::class, 'checkout']);

Route::get('/login', [PageController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/products', [PageController::class, 'products'])->middleware('auth');
Route::post('/products', [ProductController::class, 'delete'])->middleware('auth');

Route::get('/product/{id?}', [PageController::class, 'product'])->whereNumber('id')->middleware('auth');
Route::post('/product/{id}', [ProductController::class, 'edit'])->middleware('auth');
Route::post('/product', [ProductController::class, 'insert'])->middleware('auth');

Route::get('/order/{id}', [PageController::class, 'order'])->whereNumber('id');

Route::get('/orders', [PageController::class, 'orders'])->middleware('auth');




