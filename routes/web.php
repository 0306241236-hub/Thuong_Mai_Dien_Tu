<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
// Trang chủ hiển thị trạng thái đăng nhập, nút test Admin và nút Đăng xuất
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return '
        <!DOCTYPE html>
        <html lang="vi">
        <head><meta charset="UTF-8"><title>Trang chủ</title></head>
        <body style="font-family: sans-serif; max-width: 500px; margin: 60px auto; line-height: 1.6;">
            <h2>Xin chào, ' . e($user->full_name) . '!</h2>
            <p><strong>Email:</strong> ' . e($user->email) . '</p>
            <p><strong>Quyền hiện tại (Role):</strong> <span style="color: blue; font-weight: bold;">' . e($user->role) . '</span></p>
            <hr style="margin: 20px 0;">
            <div style="display: flex; gap: 12px; align-items: center;">
                <a href="/admin" style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px;">
                    Thử vào trang /admin
                </a>
                <form method="POST" action="/logout" style="margin: 0;">
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
    <body style="font-family: sans-serif; max-width: 500px; margin: 60px auto;">
        <h2>Bạn chưa đăng nhập</h2>
        <p><a href="/login">Đăng nhập</a> | <a href="/register">Đăng ký</a></p>
    </body>
    </html>';
});

Route::get('/Register', fn () => redirect('/register'));
Route::get('/Login', fn () => redirect('/login'));

// Trang đăng ký
Route::get('/register', function () {
    $errorsHtml = '';
    if (session('errors')) {
        foreach (session('errors')->all() as $err) {
            $errorsHtml .= '<p style="color:red; margin: 4px 0;">• ' . e($err) . '</p>';
        }
    }

    return '
    <!DOCTYPE html>
    <html lang="vi">
    <head><meta charset="UTF-8"><title>Đăng ký</title></head>
    <body style="font-family: sans-serif; max-width: 400px; margin: 40px auto;">
        <h2>Đăng ký tài khoản</h2>
        ' . $errorsHtml . '
        <form method="POST" action="/register">
            <div style="margin-bottom: 12px;">
                <label>Họ và tên:</label><br>
                <input type="text" name="full_name" value="' . e(old('full_name')) . '" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 12px;">
                <label>Email:</label><br>
                <input type="email" name="email" value="' . e(old('email')) . '" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 12px;">
                <label>Số điện thoại (không bắt buộc):</label><br>
                <input type="text" name="phone" value="' . e(old('phone')) . '" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 12px;">
                <label>Địa chỉ (không bắt buộc):</label><br>
                <input type="text" name="address" value="' . e(old('address')) . '" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 12px;">
                <label>Mật khẩu:</label><br>
                <input type="password" name="password" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 12px;">
                <label>Xác nhận mật khẩu:</label><br>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" style="padding: 8px 16px; cursor: pointer;">Đăng ký</button>
        </form>
        <p style="margin-top: 16px;">Đã có tài khoản? <a href="/login">Đăng nhập ngay</a></p>
    </body>
    </html>';
})->name('register');

// Trang đăng nhập
Route::get('/login', function () {
    $success = session('success') ? '<p style="color:green;">' . e(session('success')) . '</p>' : '';
    $error = session('errors') ? '<p style="color:red;">' . e(session('errors')->first()) . '</p>' : '';

    return '
    <!DOCTYPE html>
    <html lang="vi">
    <head><meta charset="UTF-8"><title>Đăng nhập</title></head>
    <body style="font-family: sans-serif; max-width: 400px; margin: 60px auto;">
        <h2>Đăng nhập hệ thống</h2>
        ' . $success . '
        ' . $error . '
        <form method="POST" action="/login">
            <div style="margin-bottom: 12px;">
                <label>Email:</label><br>
                <input type="email" name="email" value="' . e(old('email')) . '" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 12px;">
                <label>Mật khẩu:</label><br>
                <input type="password" name="password" required style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" style="padding: 8px 16px; cursor: pointer;">Đăng nhập</button>
        </form>
        <p style="margin-top: 16px;">Chưa có tài khoản? <a href="/register">Đăng ký tại đây</a></p>
    </body>
    </html>';
})->name('login');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Trang quản trị Admin (có middleware CheckAdmin bảo vệ)
Route::get('/admin', function (Request $request) {
    if ($request->wantsJson()) {
        return response()->json([
            'message' => 'Chào mừng Admin đến với trang quản trị!'
        ]);
    }

    return '
    <!DOCTYPE html>
    <html lang="vi">
    <head><meta charset="UTF-8"><title>Trang Quản Trị Admin</title></head>
    <body style="font-family: sans-serif; max-width: 500px; margin: 60px auto; line-height: 1.6;">
        <h2 style="color: green;">Chào mừng Admin đến với trang quản trị!</h2>
        <p>Bạn đã vượt qua lớp bảo vệ <strong>CheckAdmin Middleware</strong>.</p>
        <hr style="margin: 20px 0;">
        <div style="display: flex; gap: 12px; align-items: center;">
            <a href="/" style="padding: 8px 16px; background: #4b5563; color: white; text-decoration: none; border-radius: 4px;">
                Về trang chủ
            </a>
            <form method="POST" action="/logout" style="margin: 0;">
                <button type="submit" style="padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Đăng xuất
                </button>
            </form>
        </div>
    </body>
    </html>';
})->middleware(['auth', CheckAdmin::class]);
// Quản lý danh mục sản phẩm (TM-11)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
    });