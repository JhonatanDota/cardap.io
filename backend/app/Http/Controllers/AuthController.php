<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Auth\AuthRequest;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(AuthRequest $request): JsonResponse
    {
        $token = JWTAuth::attempt($request->validated());

        if (!$token) return response()->json(status: Response::HTTP_UNAUTHORIZED);

        return  response()->json([
            'token' => $token
        ]);
    }

    /**
     * Invalidate the token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json();
    }
}
