<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class GivePermission extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('name', 'asc')->with('children')->get();
        return apiSuccessResponse($permissions, 'Data fetched successfully', 201);
    }

    public function getUsers()
    {
        $users = User::orderBy('name', 'asc')->get();
        return apiSuccessResponse($users, 'Data fetched successfully', 201);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'array',],
            'permission_id' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
        
        $user = User::findOrFail($request->user_id['id']);
        $user->givePermissionTo($request->permission_id);
        
        return true;
    }
}
