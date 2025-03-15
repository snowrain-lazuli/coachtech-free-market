<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\VerificationController;

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;

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


//ユーザー管理系の処理
Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);

//ゲストユーザー確認可能
Route::post('/',  [ContentsController::class, 'index']);
Route::get('/',  [ContentsController::class, 'index'])->name('index');
Route::get('/item/{item_id}', [ContentsController::class, 'item'])->name('item');
Route::post('/item/{item_id}', [ContentsController::class, 'item'])->name('item');
Route::post('search', [ContentsController::class, 'search'])->name('search');

//ログイン時のみ確認可能
Route::middleware('auth')->group(function () {
    Route::post('/mypage/profile', [ContentsController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/mypage/profile', [ContentsController::class, 'showProfile'])->name('showProfile');
    Route::post('/mypage', [ContentsController::class, 'mypage']);
    Route::get('/mypage', [ContentsController::class, 'mypage'])->name('mypage');
    Route::get('/purchase/{item_id}', [ContentsController::class, 'purchase'])->name('purchase');
    Route::post('/purchase/{item_id}', [ContentsController::class, 'purchase'])->name('purchase');
    Route::get('/purchase/address/{item_id}', [ContentsController::class, 'address']);
    Route::post('/sell', [ContentsController::class, 'createSell'])->name('createSell');
    Route::get('/sell', [ContentsController::class, 'sell'])->name('sell');
    Route::post('/item/{item_id}/favorite', [ContentsController::class, 'toggleFavorite'])->name('item.favorite');
    Route::get('/payment/{contactId}', [ContentsController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/{contactId}', [ContentsController::class, 'payment'])->name('payment');
    Route::get('/payment/success', [ContentsController::class, 'paymentSuccess'])->name('payment.stripe');
});