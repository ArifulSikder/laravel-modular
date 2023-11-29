
<?php

use App\Http\Controllers\Acl\GivePermission;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Acl\RoleController;
use App\Http\Controllers\Acl\PermissionController;
use App\Http\Controllers\Acl\UserController;

Route::resource('role', RoleController::class);
Route::resource('permission', PermissionController::class);
Route::resource('user', UserController::class);
Route::get('user-get-permission/{user_id}', [UserController::class, 'userGetPermission']);
Route::resource('give-permission', GivePermission::class);
Route::get('get-users', [GivePermission::class, 'getUsers']);