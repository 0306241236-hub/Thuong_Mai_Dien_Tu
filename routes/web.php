<?php
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
feature/khung-du-an-db
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
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
BackEnd

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
feature/khung-du-an-db

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Kết nối CSDL thành công! Đang sử dụng DB: ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Lỗi kết nối CSDL: ' . $e->getMessage();
    }
});
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
// Quản lý danh mục & sản phẩm (TM-11, TM-12)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);
    });
BackEnd
