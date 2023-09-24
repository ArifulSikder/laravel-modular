<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Acl\AuthController;
use App\Http\Controllers\Acl\UserController;


//Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::any('login', 'login');
    });
    
    // Your protected routes here
    Route::middleware('auth:api')->group(function () {
        Route::group(['prefix' => 'user'], function () {
            Route::controller(UserController::class)->group(function () {
                Route::any('index', 'index');
            });
        });
    });
// });
