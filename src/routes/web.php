<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\UsersController;

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

Route::get('/', [ContentsController::class, 'index']);
Route::post('/item/{item_id}', [ContentsController::class, 'item']);
Route::get('/item', [ContentsController::class, 'item']);
Route::get('/mypage', [ContentsController::class, 'mypage']);

Route::middleware('auth')->group(function () {
    //Route::get('/mypage', [ContentsController::class, 'mypage']);
    Route::post('/mypage/profile', [ContentsController::class, 'profile']);
    Route::post('/mypage/{buy}', [ContentsController::class, 'buyed']);
    Route::post('/mypage/{sell}', [ContentsController::class, 'selled']);
    Route::get('/purchase/{item_id}', [UsersController::class, 'purchase']);
    Route::get('/purchase/address/{item_id}', [UsersController::class, 'address']);
    Route::post('/sell', [ContentsController::class, 'sell']);
});