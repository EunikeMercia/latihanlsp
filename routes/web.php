<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/category', CategoryController::class);
    Route::resource('/item', ItemController::class);
    Route::resource('/transaction', TransactionController::class);
    Route::get('/transaction/add/{id}', [TransactionController::class, 'add'])->name('transaction.add');
    Route::get('/transaction/delete/{id}', [TransactionController::class, 'delete'])->name('cart.delete');
    Route::post('/update', [TransactionController::class, 'cartUpdate'])->name('cart.update');
});
