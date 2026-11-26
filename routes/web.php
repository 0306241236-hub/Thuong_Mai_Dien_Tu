<?php

backend
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\CheckAdmin;
use App\Models\Product;
use App\Services\OrderService;

// 1. Trang chủ (tự động ẩn/hiện nút Admin theo đúng quyền của tài khoản)
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $adminButtons = $user->role === 'admin'
            ? '<a href="/admin" style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px;">Vào trang /admin</a>
               <a href="/admin/products" style="padding: 8px 16px; background: #4f46e5; color: white; text-decoration: none; border-radius: 4px;">Quản lý Sách (Admin)</a>'
            : '';

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Trang chủ hiển thị trạng thái đăng nhập, nút vào Admin và nút Đăng xuất
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $displayName = $user->full_name ?? $user->name ?? 'Người dùng';
develop

        return '
        <!DOCTYPE html>
        <html lang="vi">
        <head><meta charset="UTF-8"><title>Trang chủ</title></head>
 backend
        <body style="font-family: sans-serif; max-width: 600px; margin: 60px auto; line-height: 1.6;">
            <h2>Xin chào, ' . e($user->full_name) . '!</h2>
            <p><strong>Email:</strong> ' . e($user->email) . '</p>
            <p><strong>Quyền hiện tại (Role):</strong> <span style="color: blue; font-weight: bold;">' . e($user->role) . '</span></p>
            <hr style="margin: 20px 0;">
            <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                <a href="/products" style="padding: 8px 16px; background: #059669; color: white; text-decoration: none; border-radius: 4px;">
                    Xem Danh sách Sản phẩm

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
 develop
                </a>
                ' . $adminButtons . '
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
 backend
    <body style="font-family: sans-serif; max-width: 550px; margin: 60px auto; line-height: 1.6;">
        <h2>Hệ thống Cửa hàng Sách</h2>
        <p>Bạn chưa đăng nhập.</p>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="/products" style="padding: 8px 16px; background: #059669; color: white; text-decoration: none; border-radius: 4px;">Xem Sản phẩm</a>
            <a href="/login" style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px;">Đăng nhập</a>
            <a href="/register" style="padding: 8px 16px; background: #4b5563; color: white; text-decoration: none; border-radius: 4px;">Đăng ký</a>

    <body style="font-family: sans-serif; max-width: 520px; margin: 60px auto; line-height: 1.6;">
        <h2>Chào mừng đến với hệ thống</h2>
        <p>Bạn chưa đăng nhập. Vui lòng chọn thao tác bên dưới:</p>
        <div style="display: flex; gap: 12px;">
            <a href="/login" style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px;">Đăng nhập</a>
            <a href="/register" style="padding: 8px 16px; background: #16a34a; color: white; text-decoration: none; border-radius: 4px;">Đăng ký</a>
 develop
        </div>
    </body>
    </html>';
});

backend
// 2. Trang Danh sách Sản phẩm dành cho Customer & Khách xem hàng (/products)
Route::get('/products', function () {
    $products = Product::all();
    $rows = '';

    foreach ($products as $product) {
        $name = e($product->name ?? $product->title ?? ('Sách #' . $product->id));
        $price = number_format($product->price ?? 0, 0, ',', '.') . ' đ';
        $stock = (int) ($product->stock ?? 0);
        $stockText = $stock > 0
            ? '<span style="color: green; font-weight: bold;">Còn ' . $stock . '</span>'
            : '<span style="color: red; font-weight: bold;">Hết hàng</span>';

        $actionBtn = $stock > 0
            ? '<a href="/checkout?product_id=' . $product->id . '" style="padding: 6px 12px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">Đặt mua</a>'
            : '<span style="color: #9ca3af; font-size: 14px;">Tạm hết</span>';

        $rows .= '
        <tr style="border-bottom: 1px solid #e5e7eb;">
            <td style="padding: 12px;">' . $product->id . '</td>
            <td style="padding: 12px; font-weight: bold;">' . $name . '</td>
            <td style="padding: 12px;">' . $price . '</td>
            <td style="padding: 12px;">' . $stockText . '</td>
            <td style="padding: 12px;">' . $actionBtn . '</td>
        </tr>';
    }

    if ($rows === '') {
        $rows = '<tr><td colspan="5" style="padding: 16px; text-align: center;">Chưa có sản phẩm nào trong cửa hàng.</td></tr>';
    }

    $errorAlert = session('error')
        ? '<div style="padding: 12px; background: #fee2e2; color: #b91c1c; border: 1px solid #f87171; border-radius: 4px; margin-bottom: 16px;">' . e(session('error')) . '</div>'
        : '';

    $authBar = Auth::check()
        ? '<span>Xin chào, <strong>' . e(Auth::user()->full_name) . '</strong> (' . e(Auth::user()->role) . ')</span>
           <a href="/" style="margin-left: 12px;">Trang chủ</a>
           <a href="/logout" style="margin-left: 12px; color: #dc2626;">Đăng xuất</a>'
        : '<a href="/login">Đăng nhập</a> | <a href="/register">Đăng ký</a>';

    return '
    <!DOCTYPE html>
    <html lang="vi">
    <head><meta charset="UTF-8"><title>Danh sách Sản phẩm</title></head>
    <body style="font-family: sans-serif; max-width: 800px; margin: 40px auto; line-height: 1.6;">
        ' . $errorAlert . '
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Danh sách Sách</h2>
            <div>' . $authBar . '</div>
        </div>
        <table style="width: 100%; border-collapse: collapse; text-align: left; border: 1px solid #e5e7eb;">
            <thead>
                <tr style="background: #1f2937; color: white;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Tên sách</th>
                    <th style="padding: 12px;">Giá bán</th>
                    <th style="padding: 12px;">Tồn kho</th>
                    <th style="padding: 12px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>' . $rows . '</tbody>
        </table>
    </body>
    </html>';
})->name('products.index');

// 3. Đăng ký

// Giao diện & xử lý Đăng ký
 develop
Route::get('/register', function () {
    return '<form method="POST" action="/register" style="font-family: sans-serif; max-width: 400px; margin: 40px auto; line-height: 2;">
        ' . csrf_field() . '
        <h3>Đăng ký tài khoản</h3>
        Họ tên: <input type="text" name="full_name" required><br>
        Email: <input type="email" name="email" required><br>
        SĐT: <input type="text" name="phone"><br>
        Địa chỉ: <input type="text" name="address"><br>
        Mật khẩu: <input type="password" name="password" required><br>
        Xác nhận MK: <input type="password" name="password_confirmation" required><br>
        <button type="submit" style="margin-top: 10px;">Đăng ký</button>
    </form>';
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

 backend
// 4. Đăng nhập
Route::get('/login', function () {
    $error = session('errors') ? session('errors')->first('email') : '';
    return '<div style="font-family: sans-serif; max-width: 400px; margin: 40px auto; line-height: 2;">
        <h3>Đăng nhập hệ thống</h3>
        <p style="color:red;">' . $error . '</p>
        <form method="POST" action="/login">
            ' . csrf_field() . '
            Email: <input type="email" name="email" required><br>
            Mật khẩu: <input type="password" name="password" required><br>
            <button type="submit" style="margin-top: 10px;">Đăng nhập</button>
        </form>
        <p>Chưa có tài khoản? <a href="/register">Đăng ký tại đây</a></p>
    </div>';
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
 develop
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

// 5. Đăng xuất (hỗ trợ cả nút bấm POST và gõ trực tiếp GET /logout)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});

 backend
// 6. Chuyển hướng /login/product sang trang danh sách sản phẩm chung
Route::redirect('/login/product', '/products');

// 7. Trang Quản trị Admin (/admin) - Chặn Customer bằng CheckAdmin

// Thanh toán & đặt hàng (Customer)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [OrderController::class, 'success'])->name('checkout.success');
});

// Kiểm tra kết nối CSDL
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Kết nối CSDL thành công! Đang sử dụng DB: ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Lỗi kết nối CSDL: ' . $e->getMessage();
    }
});

// Trang tổng quan Quản trị (Admin)
 develop
Route::get('/admin', function () {
    return '
    <!DOCTYPE html>
    <html lang="vi">
    <head><meta charset="UTF-8"><title>Trang Quản Trị Admin</title></head>
 backend
    <body style="font-family: sans-serif; max-width: 550px; margin: 60px auto; line-height: 1.6;">
        <h2 style="color: green;">Chào mừng Admin: ' . e(auth()->user()->full_name) . '!</h2>
        <p>Bạn đã vượt qua lớp bảo vệ <strong>CheckAdmin Middleware</strong>.</p>
        <hr style="margin: 20px 0;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <a href="/admin/products" style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px;">
                Quản lý Sản phẩm (Sách)
            </a>
            <a href="/admin/categories" style="padding: 8px 16px; background: #059669; color: white; text-decoration: none; border-radius: 4px;">
                Quản lý Danh mục

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
 develop
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

 backend
// 8. Quản lý danh mục & sản phẩm dành riêng cho Admin (TM-11, TM-12) - Chặn Customer bằng CheckAdmin
Route::middleware(['auth', CheckAdmin::class])

// Quản lý danh mục & sản phẩm (TM-11, TM-12)
Route::middleware(['auth', 'admin'])
 develop
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);
 backend
    });

// 9. Đặt hàng (TM-06)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [OrderController::class, 'success'])->name('checkout.success');
});

// 10. Route tạm kiểm thử đặt hàng đồng thời sách ID 9 (xóa đoạn này trước khi git commit)
Route::get('/test-order/{userId}', function ($userId, OrderService $orderService) {
    try {
        $order = $orderService->placeOrder(
            (int) $userId,
            [
                'customer_name'    => "Khách test {$userId}",
                'customer_phone'   => '0901234567',
                'shipping_address' => 'TP.HCM',
            ],
            [
                ['product_id' => 9, 'quantity' => 1]
            ]
        );
        return "User {$userId} ĐẶT THÀNH CÔNG! Mã đơn: #{$order->id}";
    } catch (\Exception $e) {
        return "User {$userId} BỊ TỪ CHỐI: " . $e->getMessage();
    }
});

    });
 develop
