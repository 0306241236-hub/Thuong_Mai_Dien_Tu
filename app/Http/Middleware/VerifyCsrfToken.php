<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Các URI được loại trừ khỏi kiểm tra CSRF.
     * Đã làm rỗng để bật bảo mật CSRF cho toàn bộ hệ thống.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}