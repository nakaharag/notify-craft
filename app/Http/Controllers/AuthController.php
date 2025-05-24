<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $req): \Illuminate\Http\JsonResponse
    {
        $data = $req->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return response()->json(compact('user', 'token'), 201);
    }

    public function anonymous(Request $request): UserResource
    {
        $user = User::create([
            'name'     => 'Anonymous ' . Str::uuid(),
            'email'    => 'anonymous+' . Str::uuid() . '@anon.com',
            'password' => Hash::make(Str::random(16)),
        ]);

        Auth::login($user);

        return new UserResource($user);
    }

    public function login(Request $req): \Illuminate\Http\JsonResponse
    {
        $creds = $req->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($creds)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = Auth::user()->createToken('api')->plainTextToken;

        return response()->json([
            'user'  => Auth::user(),
            'token' => $token,
        ]);
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
