<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Trang chủ hiển thị trạng thái đăng nhập, nút vào Admin và nút Đăng xuất
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $displayName = $user->full_name ?? $user->name ?? 'Người dùng';

        return '
        <!DOCTYPE html>
        <html lang="vi">
        <head><meta charset="UTF-8"><title>Trang chủ</title></head>
        <body style="font-family: sans-serif; max-width: 520px; margin: 60px auto; line-height: 1.6;">
            <h2>Xin chào, ' . e($displayName) . '!</h2>
            <p><strong>Email:</strong> ' . e($user->email) . '</p>
            <p><strong>Quyền hiện tại (Role):</strong> <span style="color: blue; font-weight: bold;">' . e($user->role) . '</span></p>
            <hr style="margin: 20px 0;">
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <a href="/admin/products" style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px;">
                    Quản lý sản phẩm
                </a>
                <a href="/admin" style="padding: 8px 16px; background: #4b5563; color: white; text-decoration: none; border-radius: 4px;">
                    Trang /admin
                </a>
                <form method="POST" action="/logout" style="margin: 0;">
                    ' . csrf_field() . '
                    <button type="submit" style="padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </body>
        </html>';
    }

    return '
    <!DOCTYPE html>
    <html lang="vi">
    <head><meta charset="UTF-8"><title>Trang chủ</title></head>
    <body style="font-family: sans-serif; max-width: 520px; margin: 60px auto; line-height: 1.6;">
        <h2>Chào mừng đến với hệ thống</h2>
        <p>Bạn chưa đăng nhập. Vui lòng chọn thao tác bên dưới:</p>
        <div style="display: flex; gap: 12px;">
            <a href="/login" style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px;">Đăng nhập</a>
            <a href="/register" style="padding: 8px 16px; background: #16a34a; color: white; text-decoration: none; border-radius: 4px;">Đăng ký</a>
        </div>
    </body>
    </html>';
});

// Giao diện & xử lý Đăng ký
Route::get('/register', function () {
    return '<form method="POST" action="/register">
        ' . csrf_field() . '
        Họ tên: <input type="text" name="full_name" required><br>
        Email: <input type="email" name="email" required><br>
        SĐT: <input type="text" name="phone"><br>
        Địa chỉ: <input type="text" name="address"><br>
        Mật khẩu: <input type="password" name="password" required><br>
        Xác nhận MK: <input type="password" name="password_confirmation" required><br>
        <button type="submit">Đăng ký</button>
    </form>';
});
Route::post('/register', [AuthController::class, 'register']);

// Giao diện & xử lý Đăng nhập
Route::get('/login', function () {
    $error = session('errors') ? session('errors')->first('email') : '';
    return '<p style="color:red;">' . e($error) . '</p>
    <form method="POST" action="/login">
        ' . csrf_field() . '
        Email: <input type="email" name="email" required><br>
        Mật khẩu: <input type="password" name="password" required><br>
        <button type="submit">Đăng nhập</button>
    </form>';
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Xử lý Đăng xuất
Route::post('/logout', [AuthController::class, 'logout']);

// Thanh toán & đặt hàng (Customer)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [OrderController::class, 'success'])->name('checkout.success');
});

// Trang tổng quan Quản trị (Admin)
Route::get('/admin', function () {
    return '
    <!DOCTYPE html>
    <html lang="vi">
    <head><meta charset="UTF-8"><title>Trang Quản Trị Admin</title></head>
    <body style="font-family: sans-serif; max-width: 520px; margin: 60px auto; line-height: 1.6;">
        <h2 style="color: green;">Chào mừng Admin đến với trang quản trị!</h2>
        <p>Bạn đã vượt qua lớp bảo vệ <strong>CheckAdmin Middleware</strong>.</p>
        <hr style="margin: 20px 0;">
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <a href="/admin/products" style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px;">
                Quản lý sản phẩm
            </a>
            <a href="/admin/categories" style="padding: 8px 16px; background: #0d9488; color: white; text-decoration: none; border-radius: 4px;">
                Quản lý danh mục
            </a>
            <a href="/" style="padding: 8px 16px; background: #4b5563; color: white; text-decoration: none; border-radius: 4px;">
                Về trang chủ
            </a>
            <form method="POST" action="/logout" style="margin: 0;">
                ' . csrf_field() . '
                <button type="submit" style="padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Đăng xuất
                </button>
            </form>
        </div>
    </body>
    </html>';
})->middleware(['auth', CheckAdmin::class]);

// Quản lý danh mục & sản phẩm (TM-11, TM-12)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);
    });