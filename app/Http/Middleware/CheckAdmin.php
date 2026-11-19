<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra đã đăng nhập chưa và vai trò có phải admin không
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Truy cập bị từ chối! Bạn không có quyền quản trị viên.'
            ], 403);
        }

        return $next($request);
    }
}