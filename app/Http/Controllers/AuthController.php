<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('JualMobilToken')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user]);
        }

        return response()->json(['message' => 'Invalid login credentials'], 401);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // Profile
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function unauthenticated()
    {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}
