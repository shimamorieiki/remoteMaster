<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Route::get('/test', 'TestAPIController@index');
// Route::get('/',"BbsEntryController@index");
Route::get('/test', [TestAPIController::class, 'index']);