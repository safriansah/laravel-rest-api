<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthenticationService
{
    public function login($email, $password)
    {
        if (!Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            throw new AuthenticationException('Invalid credentials');
        }

        $user = User::where('email', $email)->firstOrFail();
        $token = $user->createToken('JualMobilToken')->plainTextToken;

        return ['token' => $token, 'user' => $user];
    }
}