<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Modules\Post\Http\Controllers\PostController;

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

Route::middleware('auth:api')->get('/post', function (Request $request) {
    return $request->user();
});

Route::controller(PostController::class)->prefix('post')->name('post.')->group(function(){
    Route::get('index', 'index');
    Route::post('store', 'store');
    Route::post('show', 'show');
    Route::post('update', 'update');
    Route::delete('delete', 'delete');
});