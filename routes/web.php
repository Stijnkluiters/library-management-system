<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
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
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::post('/book/{title}', [BookController::class, 'order'])->name('books.order');
Route::post('/orders/{title}', [BookController::class, 'return'])->name('books.return');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
