<?php

namespace App\Http\Controllers\Acl;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "code" => 400,
                "error" =>  $validator->errors(),
                "item" => []
            ]);

        }
        $result =  $this->userRepository->store($request);
        if ($result) {
            return response()->json([
                "success" => true,
                "code" => 200,
                "message" => "User saved successfully"
            ]);
        } else {
            return response()->json([
                "code" => 400,
                "message" => "Something went wrong please try again"
            ]);
        }
    }

    public function login(Request $request)
    {
       dd('asdf');
    }

}
