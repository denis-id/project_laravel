<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function register(Request $request)
    {
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Registration Failed', 'error' => $e->getMessage()],400);
        }
    }

    public function login(Request $request)
    {
    try {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Login successful', 'user' => Auth::user()], 200);
        }

        return response()->json(['message' => 'Invalid user'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Login Failed', 'error' => $e->getMessage()],400);
        }
    }
}