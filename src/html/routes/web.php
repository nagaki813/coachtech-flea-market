<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;

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

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('item/{item}', [ItemController::class, 'show'])->name('items.show');

Route::post('/comment', [CommentController::class, 'store'])->middleware('auth');
Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

Route::post('/like', [LikeController::class, 'toggle'])->name('likes.toggle')->middleware('auth');

Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index')->middleware('auth');
Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchases.store')->middleware('auth');