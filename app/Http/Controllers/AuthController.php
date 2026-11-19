<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        // Lấy dữ liệu đã qua kiểm duyệt (validate) và chuyển xuống Service xử lý
        $user = $this->authService->register($request->validated());

        // Trả về phản hồi JSON thông báo thành công
        return response()->json([
            'message' => 'Đăng ký thành công!', 
            'user' => $user
        ], 201);
    }
}