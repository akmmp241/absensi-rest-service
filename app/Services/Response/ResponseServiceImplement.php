<?php

namespace App\Services\Response;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use LaravelEasyRepository\ServiceApi;

class ResponseServiceImplement extends ServiceApi implements ResponseService
{

    public function standardResponse(bool $success, string $message, int $code): JsonResponse
    {
        return response()->json([
            "data" => [
                "success" => $success,
                "message" => $message
            ]
        ], $code);
    }

    public function errorResponse(MessageBag $data, int $code): JsonResponse
    {
        return response()->json([
            "errors" => [
                $data
            ]
        ], $code);
    }

    public function dataResponse(string $message, int $code, array $data): JsonResponse
    {
        return response()->json([
            "data" => [
                "success" => true,
                "message" => $message,
                $data
            ]
        ], $code);
    }

    public function respondWithToken(string $token): JsonResponse
    {
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
