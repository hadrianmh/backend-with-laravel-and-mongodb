<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => ['required','string','email','max:255','unique:users'],
            'password'  => ['required','string','min:8', Password::min(8)->letters()->mixedCase()->symbols()->uncompromised()]
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Registration failed', 'data' => $validator->errors()], 400);
        }

        $user = User::create([
            'uuid'      => Str::uuid()->toString(),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password')),
        ]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Registration successfully'
        ], 201);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Unauthorized'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status'    => 'success',
            'message'   => 'Login successfully',
            'data'      => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL()
            ]
        ], 200);
    }
}
