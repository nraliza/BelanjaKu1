<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class DummyJwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            // Ambil payload token JWT
            $payload = JWTAuth::parseToken()->getPayload();
            // Masukkan payload ke request untuk digunakan di controller
            $request->merge(['jwt_payload' => $payload]);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Token invalid or expired'
            ], 401);
        }

        return $next($request);
    }
}