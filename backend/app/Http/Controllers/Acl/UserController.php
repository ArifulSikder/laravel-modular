<?php

namespace App\Http\Controllers\Acl;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\CommonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $items = $this->userRepository->getAll();
        if ($items->isEmpty()) {
            return apiErrorResponse($items);
        }
        return apiSuccessResponse($items, 'Data fetched successfully', 201);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }

        $result =  $this->userRepository->store($request);
        if ($result) {
            return apiSuccessResponse($result = null, 'Data saved successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
        }
    }
    
    public function userGetPermission($user_id)
    {
        $validator = Validator::make(['id' => $user_id], [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }

        $permissions = DB::table('model_has_permissions')->where('model_id', $user_id)->get();

        if ($permissions->count() > 0) {
            return apiSuccessResponse($result = new CommonResource($permissions), 'Data retrieved successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
        }
    }
}
