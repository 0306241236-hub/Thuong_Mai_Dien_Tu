<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Chưa đăng nhập -> đẩy về trang đăng nhập
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Đã đăng nhập nhưng role không phải 'admin' (tức là 'customer') -> chặn và đẩy về /products
        if (Auth::user()->role !== 'admin') {
            return redirect('/products')->with('error', 'Bạn không có quyền truy cập trang quản trị Admin!');
        }

        return $next($request);
    }
}