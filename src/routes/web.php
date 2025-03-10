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

// メール認証通知画面
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth', 'verified'])->name('verification.notice');

// メール確認後の処理
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

// 確認メールの再送信
Route::post('/email/verification-notification', [VerificationController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

//ゲストユーザー確認可能
Route::post('/',  [ContentsController::class, 'index']);
Route::get('/',  [ContentsController::class, 'index'])->name('index');
Route::get('/item/{item_id}', [ContentsController::class, 'item']);
Route::get('/item', [ContentsController::class, 'item']);
Route::post('search', [ContentsController::class, 'search']);

//ログイン時のみ確認可能
Route::middleware('auth')->group(function () {
    Route::post('/mypage/profile', [ContentsController::class, 'updateProfile']);
    Route::get('/mypage/profile', [ContentsController::class, 'showProfile'])->name('showProfile');
    Route::post('/mypage', [ContentsController::class, 'mypage']);
    Route::get('/mypage', [ContentsController::class, 'mypage'])->name('mypage');
    Route::get('/purchase/{item_id}', [ContentsController::class, 'purchase']);
    Route::post('/purchase/{item_id}', [ContentsController::class, 'purchase']);
    Route::get('/purchase/address/{item_id}', [ContentsController::class, 'address']);
    Route::get('/sell', [ContentsController::class, 'sell']);
    Route::post('/sell', [ContentsController::class, 'sell']);
    Route::post('/item/{item_id}', [ContentsController::class, 'item'])->name('item');
    Route::get('/purchase/{item_id}', [ContentsController::class, 'purchase']);
    Route::get('/purchase/address/{item_id}', [ContentsController::class, 'address']);
    Route::post('/item/{item_id}/favorite', [ContentsController::class, 'toggleFavorite'])->name('item.favorite');
});