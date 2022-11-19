<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth'], function (){
    Route::post('createpost', [PostController::class, 'createPost']);
    Route::put('updatepost/{post}', [PostController::class, 'updatePost']);
    Route::delete('deletepost/{post}', [PostController::class, 'deletePost']);

    Route::post('user', [\App\Http\Controllers\UserController::class, 'getUser']);
    Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout']);
});

Route::post('getposts', [PostController::class, 'getPosts']);

Route::post('register', [\App\Http\Controllers\UserController::class, 'register']);
Route::post('login', [\App\Http\Controllers\UserController::class, 'login']);



