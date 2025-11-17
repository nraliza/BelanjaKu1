<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DummyUser;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Dummy user (1 akun saja)
    private $user = [
        'id' => 1,
        'name' => 'User Satu',
        'email' => 'user@example.com',
        'password' => 'password123',
        'role' => 'user'
    ];

    // LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required|string"
        ]);

        // cek kredensial
        if ($credentials['email'] !== $this->user['email'] ||
            $credentials['password'] !== $this->user['password']) {

            return response()->json([
                "message" => "Invalid email or password"
            ], 401);
        }

        $user = new DummyUser($this->user);

        // buat token
        $token = JWTAuth::claims([
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role
        ])->fromUser($user);

        return response()->json([
            "message" => "Login successful",
            "token" => $token
        ]);
    }

    // PROFILE (Protected)
    public function profile(Request $request)
    {
        $payload = $request->jwt_payload;

        return response()->json([
            'email' => $payload->get('email'),
            'name' => $payload->get('name'),
            'role' => $payload->get('role')
        ]);
    }
}
