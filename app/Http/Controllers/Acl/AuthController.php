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
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $result = $user->createToken('MyApp')->accessToken;
            return apiSuccessResponse($result, 'Logged in successfully');
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

}
