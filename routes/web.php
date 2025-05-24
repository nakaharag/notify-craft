<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\AuthController;

Route::post('/login/anonymous', [AuthController::class, 'anonymous']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');

Route::get('/', function () {
    return Inertia::render('Home');
});
