<?php

use App\Http\Controllers\API\Activity\ActivityController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Doc\DocumentationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/users')->group(function () {
    Route::post('/', [AuthController::class, 'login'])->middleware('guest:api');
    Route::get('/', [AuthController::class, 'get'])->middleware('auth:api');
    Route::delete('/', [AuthController::class, 'logout'])->middleware('auth:api');
});

Route::middleware('auth:api')->prefix('/students')->group(function () {
    Route::post('/activities', [ActivityController::class, 'create']);
    Route::get('/activities', [ActivityController::class, 'all']);
});

Route::get('/docs', [DocumentationController::class, 'get'])->name('docs');
