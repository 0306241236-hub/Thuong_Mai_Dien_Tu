<?php
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckAdmin;

// Giao diện test Đăng ký
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

// Giao diện test Đăng nhập
Route::get('/login', function () {
    $error = session('errors') ? session('errors')->first('email') : '';
    return '<p style="color:red;">' . $error . '</p>
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

// Trang chủ (Dành cho Customer hoặc User đã đăng nhập)
Route::get('/', function () {
    if (!auth()->check()) return 'Vui lòng <a href="/login">Đăng nhập</a>';
    
    return '<h1>Trang chủ (Khách hàng)</h1>
    <p>Xin chào, ' . auth()->user()->full_name . '</p>
    <form method="POST" action="/logout">
        ' . csrf_field() . '
        <button type="submit">Đăng xuất</button>
    </form>';
})->middleware('auth');

// Trang Quản trị (Chỉ dành cho Admin)
Route::get('/admin', function () {
    return '<h1>Trang Quản Trị (Admin)</h1>
    <p>Xin chào quản trị viên: ' . auth()->user()->full_name . '</p>
    <form method="POST" action="/logout">
        ' . csrf_field() . '
        <button type="submit">Đăng xuất</button>
    </form>';
})->middleware(['auth', CheckAdmin::class]);

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [OrderController::class, 'success'])->name('checkout.success');
});