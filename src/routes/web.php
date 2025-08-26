<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReviewController;
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
    Route::post('/item/{item_id}/favorite', [ContentsController::class, 'toggleFavorite'])->name('item.favorite');
    Route::post('/sell', [ContentsController::class, 'createSell'])->name('createSell');
    Route::get('/sell', [ContentsController::class, 'sell'])->name('sell');
    // 購入ページ表示
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('purchase');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchasePost'])->name('purchase.post');

    // 配送先変更ページ
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])->name('purchase.address');

    // Stripe PaymentIntent作成（Ajax）
    Route::post('/purchase/{item_id}/payment-intent', [PurchaseController::class, 'createPaymentIntent'])->name('purchase.paymentIntent');

    // 決済成功後のDB更新（Ajax）
    Route::post('/purchase/payment/success', [PurchaseController::class, 'paymentSuccess'])->name('purchase.paymentSuccess');

    // Stripe決済画面
    Route::get('/payment/stripe/{item_id}', [PurchaseController::class, 'showStripePayment'])->name('payment.stripe');
    Route::get('/payment/intent/{item_id}', [PurchaseController::class, 'createPaymentIntent'])->name('payment.intent');

    // 取引チャット画面
    Route::get('/purchases/{payment_id}/chat', [PurchaseController::class, 'chat'])->name('purchase.chat');

    // メッセージ投稿
    Route::post('/purchases/{payment_id}/messages', [PurchaseController::class, 'store'])->name('messages.store');

    // メッセージ編集
    Route::patch('/messages/{message}', [PurchaseController::class, 'update'])->name('messages.update');

    // メッセージ削除
    Route::delete('/messages/{message}', [PurchaseController::class, 'destroy'])->name('messages.destroy');

    // 取引完了
    Route::post('/purchases/complete/{payment_id}', [PurchaseController::class, 'complete'])->name('purchase.complete');

    Route::post('/reviews/{payment_id}', [ReviewController::class, 'store'])->name('reviews.store');

    //チャット保存用
    Route::post('/chat/draft/save', [PurchaseController::class, 'save']);
    Route::get('/chat/draft/load/{payment_id}', [PurchaseController::class, 'load']);
});