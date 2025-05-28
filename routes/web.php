<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('web')->prefix('api')->group(function () {
    Route::post('register',          [AuthController::class, 'register']);
    Route::post('login',             [AuthController::class, 'login']);
    Route::post('login/anonymous',   [AuthController::class, 'anonymous']);
    Route::post('logout',            [AuthController::class, 'logout']);
});

Route::middleware('guest')->group(function () {
    Route::get('/login',    fn() => Inertia::render('Login'))->name('login');
    Route::get('/register', fn() => Inertia::render('Register'))->name('register');
});

Route::middleware(['web','auth:sanctum'])
    ->get('/post-its', [\App\Http\Controllers\Api\PostItController::class, 'index'])
    ->name('post-its.index');

// keep root route
Route::get('/', fn() => Inertia::render('Home'));
