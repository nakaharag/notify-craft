<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostItController;
use App\Http\Resources\UserResource;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', fn() => new UserResource(auth()->user()));
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('post-its', PostItController::class);
});
