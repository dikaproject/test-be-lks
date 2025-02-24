<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'user'; 

        $user = User::create($validated);

        $token = $user->createToken('api-token')->plainTextToken;

        $response = [
            'user' => UserResource::make($user),
            'token' => $token
        ];

        return ResponseHelper::jsonResponse(true, 'Akun Berhasil di registrasi', $response, 200);
    }
    public function login(LoginRequest $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseHelper::jsonResponse(false, 'invalid credentials', null, 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        $response = [
            'user' => UserResource::make($user),
            'token' => $token
        ];

        return ResponseHelper::jsonResponse(true, 'Login has been successfuly', $response, 200);
    }
}
