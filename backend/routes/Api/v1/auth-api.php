<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Acl\AuthController;
use App\Http\Controllers\Acl\RoleController;
use App\Http\Controllers\Acl\UserController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
});

Route::group(['middleware' => ['cors', 'json.response', 'auth:sanctum']], function () {
    // Route::controller(AuthController::class)->group(function () {
    //     Route::any('login', 'login')->name('login');
    // });

    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('logout', 'logout');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::controller(UserController::class)->group(function () {
            Route::any('index', 'index');
        });
    });
});
