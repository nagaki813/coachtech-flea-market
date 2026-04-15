<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

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

Route::post('/comment', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

Route::post('/likes/toggle/{item}', [ItemController::class, 'toggle'])->middleware('auth')->name('likes.toggle');
Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index')->middleware('auth');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('purchase/thanks', [PurchaseController::class, 'thanks'])->name('purchases.thanks');
    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])->name('purchases.address.edit');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('purchases.address.update');
});

Route::middleware('auth')->group(function() {
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
});

Route::middleware('auth')->group(function() {
    Route::get('/sell', [SellController::class, 'create'])->name('sell.create');
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/stripe/success', [PurchaseController::class, 'stripeSuccess'])->middleware(['auth', 'verified'])->name('stripe.success');