<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

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

Route::post('/comment', [CommentController::class, 'store']);
Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::post('/like', [LikeController::class, 'toggle'])->name('likes.toggle');