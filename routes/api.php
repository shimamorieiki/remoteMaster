<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestAPIController;
use App\Http\Controllers\TestDBController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// routeの書き方が変わった
// https://teratail.com/questions/292482#reply-413765
// TestAPIControllerはいじらない
Route::get('/test', [TestAPIController::class, 'index']);

Route::get('/db', [TestDBController::class, 'index']);

// Route::get('/user', [UserController::class, 'index']);
// ログイン
// Route::get($uri, $callback);
// Route::post($uri, $callback);
// Route::put($uri, $callback);
// Route::patch($uri, $callback);
// Route::delete($uri, $callback);
// Route::options($uri, $callback);

// リモ達
Route::get('/user', [UserController::class, 'get_users_with_token']);
Route::post('/user', [UserController::class, 'post_completed_task']);
// Route::put($uri, $callback);
// Route::patch($uri, $callback);
// Route::delete($uri, $callback);
// Route::options($uri, $callback);


// 宝くじ
// Route::get($uri, $callback);
// Route::post($uri, $callback);
// Route::put($uri, $callback);
// Route::patch($uri, $callback);
// Route::delete($uri, $callback);
// Route::options($uri, $callback);