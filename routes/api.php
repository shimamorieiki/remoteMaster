<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
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
Route::middleware('auth:sanctum')->post('/register', [RegisterController::class, 'register']);

// ログイン
Route::post('/login', [LoginController::class, 'login']);

// routeの書き方が変わった
// https://teratail.com/questions/292482#reply-413765

// リモ達(api/user)
Route::middleware('auth:sanctum')->get('/user',[UserController::class, 'get_user_info']);
Route::middleware('auth:sanctum')->post('/user', [UserController::class, 'post_completed_task']);

// タスク追加(api/task)
Route::middleware('auth:sanctum')->post('/task',[TaskController::class, 'add_new_task']);
Route::middleware('auth:sanctum')->put('/task', [TaskController::class, 'update_task']);

// 宝くじ(api/lottery)
Route::middleware('auth:sanctum')->get('/lottery', [LotteryController::class, 'get_winner']);
Route::middleware('auth:sanctum')->post('/lottery', [LotteryController::class, 'post_voting']);