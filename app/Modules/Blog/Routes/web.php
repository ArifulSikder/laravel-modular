<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Blog\Controllers\BlogController;

Route::controller(BlogController::class)->prefix('blog')->name('blog.')->group(function () {
    Route::get('index', 'index')->name('index');
    Route::get('edit/{id}', 'edit')->name('edit');
    Route::any('update/{id}', 'update')->name('update');
    Route::delete('delete/{id}', 'delete')->name('delete');
});
