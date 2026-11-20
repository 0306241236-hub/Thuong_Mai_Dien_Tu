<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Đăng ký thành công!',
                'data' => $user
            ], 201);
        }

        return redirect('/login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        $request->session()->regenerate();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Đăng nhập thành công!',
                'data' => $result
            ], 200);
        }

        return redirect()->intended(is_array($result) ? ($result['redirect_url'] ?? '/') : '/');
    }

    public function logout(Request $request)
    {
        $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Đăng xuất thành công!'
            ], 200);
        }

        return redirect('/login');
    }
}