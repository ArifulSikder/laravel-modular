<?php

use Modules\Blog\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::controller(BlogController::class)->prefix('blog')->name('blog.')->group(function () {
    Route::any('/index', 'index')->name('index');
    Route::any('/create', 'create')->name('create');
    Route::any('/store', 'store')->name('store');
    Route::any('/edit', 'edit')->name('edit');
    Route::any('/update', 'update')->name('update');
    Route::any('/delete', 'update')->name('update');
});
