<?php

namespace App\Http\Controllers\Acl;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                "code" => 400,
                "message" =>  ['error' => $validator->errors()->all()],
                "items" => []
            ]);

        }

        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    public function login(Request $request)
    {
       dd('asdf');
    }

}
