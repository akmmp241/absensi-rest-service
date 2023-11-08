<?php

namespace App\Services\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use LaravelEasyRepository\BaseService;

interface ResponseService extends BaseService
{
    public function standardResponse(bool $success, string $message, int $code): JsonResponse;

    public function errorResponse(MessageBag $data, int $code): JsonResponse;

    public function dataResponse(string $message, int $code, array $data): JsonResponse;

    public function respondWithToken(string $token): JsonResponse;
}
