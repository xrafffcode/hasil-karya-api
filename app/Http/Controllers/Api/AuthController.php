<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (! Auth::attempt($credentials)) {
            return response([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $user['roles'] = $user->roles()->get()->pluck('name');
        $user['user_name'] = null;
        $user['user_id'] = null;

        if ($user->checker()->exists()) {
            $user['user_id'] = $user->checker->id;
            $user['user_name'] = $user->checker->name;
        }

        if ($user->gasOperator()->exists()) {
            $user['user_id'] = $user->gasOperator->id;
            $user['user_name'] = $user->gasOperator->name;
        }

        $user_data = $user;

        if ($user->isActive() === false) {
            return response([
                'success' => false,
                'message' => 'Akun anda sedang dinonaktifkan',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'success' => true,
            'user_data' => $user_data,
            'token' => $token,
            'message' => 'Login Success',
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        $response = [
            'success' => true,
            'message' => 'Logout Success',
        ];

        return response($response, 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'confirm-password' => 'required|same:password',
        ]);

        $data = $request->except('confirm-password', 'password');

        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'success' => true,
            'user' => $user,
            'token' => $token,
            'message' => 'Register Success',
        ];

        return response($response, 201);
    }

    public function me()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->roles;

            if ($user->checker()->exists()) {
                $user->checker;
            }

            if ($user->gasOperator()->exists()) {
                $user->gasOperator;
            }

            return response()->json([
                'message' => 'User data',
                'data' => $user,
            ]);
        }

        return response()->json([
            'message' => 'You are not logged in',
        ], 401);
    }
}
