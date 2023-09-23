<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Acl\AuthController;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::controller(AuthController::class)->group(function () {
            Route::any('create', 'create');
            Route::any('login', 'login');
        });
    });
});
