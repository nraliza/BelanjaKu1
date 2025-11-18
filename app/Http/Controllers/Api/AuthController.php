<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DummyUser;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Dummy user
    private $user = [
        'id' => 1,
        'name' => 'User Satu',
        'email' => 'user@example.com',
        'password' => 'password123',
        'role' => 'user'
    ];

    // REGISTER
    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:100",
            "email" => "required|email",
            "password" => "required|string|min:6|confirmed"
        ]);

        $newUser = [
            'id' => rand(3, 999),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'user'
        ];

        return response()->json([
            "message" => "User registered successfully (dummy)",
            "user" => $newUser
        ], 201);
    }

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

    // PROFILE
    public function profile(Request $request)
    {
        $payload = $request->jwt_payload;

        return response()->json([
            'email' => $payload->get('email'),
            'name' => $payload->get('name'),
            'role' => $payload->get('role')
        ]);
    }

    // LOGOUT
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'message' => 'User logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to logout'
            ], 500);
        }
    }
}
