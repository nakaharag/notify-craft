<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Resources\UserResource;

Route::middleware('web')->prefix('api')->group(function () {
    Route::post('register',    [AuthController::class, 'register']);
    Route::post('login',       [AuthController::class, 'login']);
    Route::post('login/anonymous', [AuthController::class, 'anonymous']);
    Route::get('user',         fn() => new UserResource(auth()->user()));
    Route::post('logout',      [AuthController::class, 'logout']);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => Inertia::render('Login'))->name('login');
    Route::get('/register', fn() => Inertia::render('Register'))->name('register');
});

Route::get('/', function () {
    return Inertia::render('Home');
});
