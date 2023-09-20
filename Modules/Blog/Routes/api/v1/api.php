<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\Api\V1\BlogController;

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
Route::controller(BlogController::class)->prefix('blog')->name('blog.')->group(function () {
    Route::any('/index', 'index')->name('index');
    Route::any('/store', 'store')->name('store');
    Route::any('/show', 'show')->name('store');
    Route::any('/update', 'update')->name('update');
    Route::any('/delete', 'update')->name('update');
});
