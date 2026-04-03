<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ProfileController;

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
Route::get('/purchase/{item}', [PurchaseController::class, 'create'])->name('purchases.create');
Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchases.store')->middleware('auth');
Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])->name('purchases.address.edit')->middleware('auth');
Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('purchases.address.update')->middleware('auth');

Route::middleware('auth')->group(function() {
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
});

Route::middleware('auth')->group(function() {
    Route::get('/sell', [SellController::class, 'create'])->name('sell.create');
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});