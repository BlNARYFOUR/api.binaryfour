<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('verify', [AuthController::class, 'verify']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'get']);
    Route::get('latest/{skipId}', [BlogController::class, 'getLatest']);
    Route::get('images/{blogId}', [BlogController::class, 'getBlogImage']);
    Route::get('tags', [BlogController::class, 'getTags']);
    Route::get('{id}', [BlogController::class, 'getById']);

    Route::middleware('auth')->group(function () {
        Route::post('/', [BlogController::class, 'newBlog']);
        Route::post('/tags', [BlogController::class, 'newTag']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('logged-in', [AuthController::class, 'getLoggedIn']);
});
