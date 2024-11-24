<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);


Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);


Route::get('/posts/{postId}/comments/{id}', [CommentController::class, 'show']);

Route::middleware('auth:api')->group(function () {

    /** RUTAS PARA POST */
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    /** RUTAS PARA POST END */

    /** RUTAS PARA COMMENTS */
    Route::post('/posts/{postId}/comments', [CommentController::class, 'store']);
    Route::put('/posts/{postId}/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/posts/{postId}/comments/{id}', [CommentController::class, 'destroy']);
    /** RUTAS PARA COMMENTS END */
});
