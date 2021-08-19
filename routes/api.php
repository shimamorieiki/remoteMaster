<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ユーザー登録
Route::post('/register', [RegisterController::class, 'register']);

// ログイン
Route::post('/login', [LoginController::class, 'login']);

// routeの書き方が変わった
// https://teratail.com/questions/292482#reply-413765

// リモ達(api/user)
Route::middleware('auth:sanctum')->get('/user',[UserController::class, 'get_user_info']);
Route::middleware('auth:sanctum')->post('/user', [UserController::class, 'post_completed_task']);
// Route::put($uri, $callback);
// Route::patch($uri, $callback);
// Route::delete($uri, $callback);
// Route::options($uri, $callback);


// 宝くじ(api/lottery)
Route::middleware('auth:sanctum')->get('/lottery', [LotteryController::class, 'get_winner']);
Route::middleware('auth:sanctum')->post('/lottery', [LotteryController::class, 'post_voting']);
// Route::put($uri, $callback);
// Route::patch($uri, $callback);
// Route::delete($uri, $callback);
// Route::options($uri, $callback);