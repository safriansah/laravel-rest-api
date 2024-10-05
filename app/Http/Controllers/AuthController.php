<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthenticationService();
    }
    //
    public function login(Request $request)
    {
        return $this->handleRequest(function () use ($request) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            return $this->authService->login($request->email, $request->password);
        }, false);
    }

    // Logout
    public function logout(Request $request)
    {
        return $this->handleRequest(function () use ($request) {
            $request->user()->currentAccessToken()->delete();
            return $request->user();
        }, false);
    }

    // Profile
    public function profile(Request $request)
    {
        return $this->handleRequest(function () use ($request) {
            return $request->user();
        }, false);
    }

    public function unauthenticated()
    {
        return $this->sendResponse(true, 401, 'Unauthenticated');
    }
}
