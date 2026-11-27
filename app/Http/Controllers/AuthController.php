<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Đăng ký thành công!',
                    'data' => $user
                ], 201);
            }

            return redirect('/login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => $e->getMessage()], 422);
            }

            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->withInput();
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authService->login($request->validated());

            $request->session()->regenerate();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Đăng nhập thành công!',
                    'data' => $result
                ], 200);
            }

            return redirect()->intended(is_array($result) ? ($result['redirect_url'] ?? '/') : '/');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => $e->getMessage()], 401);
            }

            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->onlyInput('email');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

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