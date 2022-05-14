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
Route::group(['prefix' => '/v1'], function () {
    Route::post('/login', [\App\Http\Controllers\API\Auth\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\API\Auth\AuthController::class, 'register']);

});

Route::group(['prefix' => '/v1','middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [\App\Http\Controllers\API\Auth\AuthController::class, 'logout']);

    // User 
    Route::get('/user', [\App\Http\Controllers\API\UserController::class, 'index']);
    Route::post('/user/{id}', [\App\Http\Controllers\API\UserController::class, 'update']);
});

Route::group(['prefix' => '/v1/board','middleware' => 'auth:sanctum'], function () {
   Route::post('/store', [\App\Http\Controllers\API\BoardController::class, 'store']);
   Route::get('/edit/{id}', [\App\Http\Controllers\API\BoardController::class, 'edit']);
   Route::post('/update/{id}', [\App\Http\Controllers\API\BoardController::class, 'update']);
   Route::delete('/delete/{id}', [\App\Http\Controllers\API\BoardController::class, 'destroy']);
});
Route::group(['prefix' => '/v1/task','middleware' => 'auth:sanctum'], function () {
   Route::post('/store', [\App\Http\Controllers\API\TaskController::class, 'store']);
   Route::get('/edit/{id}', [\App\Http\Controllers\API\TaskController::class, 'edit']);
   Route::post('/update/{id}', [\App\Http\Controllers\API\TaskController::class, 'update']);
   Route::delete('/delete/{id}', [\App\Http\Controllers\API\TaskController::class, 'destroy']);
});