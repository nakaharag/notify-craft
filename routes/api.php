<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostItController;

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('post-its', PostItController::class);
});
