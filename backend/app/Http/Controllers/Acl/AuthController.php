<?php

namespace App\Http\Controllers\Acl;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //     public function login(Request $request)
//     {
//         $credentials = $request->only('email', 'password');
//         if (Auth::attempt($credentials)) {
//             $user = Auth::user();
//             $result = $user->createToken('MyApp')->accessToken;
//             return apiSuccessResponse($result, 'Logged in successfully');
//         }
//         return response()->json(['error' => 'Unauthorized'], 401);
//     }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        return $this->makeToken($user);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        return $this->makeToken($user);
    }

    public function makeToken($user)
    {
        $token = $user->createToken("myToken")->plainTextToken;
        return AuthResource::make([
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => "logout successful!"]);
    }
}
