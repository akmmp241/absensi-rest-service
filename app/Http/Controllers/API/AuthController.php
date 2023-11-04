<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!$token = Auth::attempt([
            "username" => $credentials["username"],
            "password" => $credentials["password"]
        ])) {
            throw new HttpResponseException(response()->json([
                "data" => [
                    "success" => false,
                    "message" => "Username or password wrong."
                ]
            ], Response::HTTP_UNAUTHORIZED));
        }

        return response()->json([
            "data" => [
                "success" => true,
                "message" => "You are now logged in.",
                "token" => $token,
                "token_type" => "Bearer",
                "expires_in" => Auth::factory()->getTTL() * 60,
                "user" => new UserResource(Auth::user()),
            ]
        ]);
    }
}
