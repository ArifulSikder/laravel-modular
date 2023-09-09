<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Blog\Controllers\BlogController;

Route::resource('blogs', BlogController::class);
