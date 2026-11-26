<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CheckAdmin;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Trang chủ (TM-01 - Frontend TV3)
Route::get('/', function () {
    $categories = [
        ['name' => 'Công nghệ thông tin', 'slug' => 'cntt', 'count' => 24],
        ['name' => 'Kinh tế', 'slug' => 'kinh-te', 'count' => 18],
        ['name' => 'Toán học', 'slug' => 'toan-hoc', 'count' => 16],
        ['name' => 'Ngoại ngữ', 'slug' => 'ngoai-ngu', 'count' => 20],
        ['name' => 'Kỹ năng', 'slug' => 'ky-nang', 'count' => 12],
    ];

    $featuredBooks = [
        ['id' => 1, 'title' => 'Lập trình C cơ bản', 'author' => 'Nguyễn Văn An', 'price' => 85000],
        ['id' => 2, 'title' => 'Kinh tế vi mô', 'author' => 'Trần Minh Hà', 'price' => 120000],
        ['id' => 3, 'title' => 'Toán cao cấp 1', 'author' => 'Lê Thị Mai', 'price' => 95000],
        ['id' => 4, 'title' => 'Tiếng Anh học thuật', 'author' => 'Phạm Thu Trang', 'price' => 110000],
    ];

    $newBooks = [
        ['id' => 5, 'title' => 'Cấu trúc dữ liệu và giải thuật', 'author' => 'Hoàng Đức Minh', 'price' => 135000],
        ['id' => 6, 'title' => 'Kỹ năng học đại học', 'author' => 'Võ Thanh Tùng', 'price' => 65000],
        ['id' => 7, 'title' => 'Xác suất thống kê', 'author' => 'Đặng Quốc Bảo', 'price' => 90000],
        ['id' => 8, 'title' => 'Nguyên lý kế toán', 'author' => 'Bùi Thị Lan', 'price' => 105000],
    ];

    return view('home', compact('categories', 'featuredBooks', 'newBooks'));
})->name('home');

// 2. Trang Danh sách & Lọc sản phẩm (TM-02 - Frontend TV3)
Route::get('/products', function (Request $request) {
    $categories = [
        ['name' => 'Công nghệ thông tin', 'slug' => 'cntt'],
        ['name' => 'Kinh tế', 'slug' => 'kinh-te'],
        ['name' => 'Toán học', 'slug' => 'toan-hoc'],
        ['name' => 'Ngoại ngữ', 'slug' => 'ngoai-ngu'],
        ['name' => 'Kỹ năng', 'slug' => 'ky-nang'],
    ];

    $allBooks = [
        ['id' => 1, 'title' => 'Lập trình C cơ bản', 'author' => 'Nguyễn Văn An', 'price' => 85000, 'category' => 'cntt'],
        ['id' => 2, 'title' => 'Kinh tế vi mô', 'author' => 'Trần Minh Hà', 'price' => 120000, 'category' => 'kinh-te'],
        ['id' => 3, 'title' => 'Toán cao cấp 1', 'author' => 'Lê Thị Mai', 'price' => 95000, 'category' => 'toan-hoc'],
        ['id' => 4, 'title' => 'Tiếng Anh học thuật', 'author' => 'Phạm Thu Trang', 'price' => 110000, 'category' => 'ngoai-ngu'],
        ['id' => 5, 'title' => 'Cấu trúc dữ liệu và giải thuật', 'author' => 'Hoàng Đức Minh', 'price' => 135000, 'category' => 'cntt'],
        ['id' => 6, 'title' => 'Kỹ năng học đại học', 'author' => 'Võ Thanh Tùng', 'price' => 65000, 'category' => 'ky-nang'],
        ['id' => 7, 'title' => 'Xác suất thống kê', 'author' => 'Đặng Quốc Bảo', 'price' => 90000, 'category' => 'toan-hoc'],
        ['id' => 8, 'title' => 'Nguyên lý kế toán', 'author' => 'Bùi Thị Lan', 'price' => 105000, 'category' => 'kinh-te'],
        ['id' => 9, 'title' => 'Cơ sở dữ liệu SQL', 'author' => 'Ngô Quang Khải', 'price' => 115000, 'category' => 'cntt'],
    ];

    $books = array_filter($allBooks, function ($book) use ($request) {
        if ($request->filled('keyword') && stripos($book['title'], $request->keyword) === false) {
            return false;
        }
        if ($request->filled('category') && $book['category'] !== $request->category) {
            return false;
        }
        if ($request->filled('min_price') && $book['price'] < (int) $request->min_price) {
            return false;
        }
        if ($request->filled('max_price') && $book['price'] > (int) $request->max_price) {
            return false;
        }
        return true;
    });

    return view('products.index', compact('categories', 'books'));
})->name('products.index');

// 3. Đăng ký (TM-04)
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

// 4. Đăng nhập (TM-04)
Route::get('/login', function () {
    $error = session('errors') ? session('errors')->first('email') : '';
    return '<div style="font-family: sans-serif; max-width: 400px; margin: 40px auto; line-height: 2;">
        <h3>Đăng nhập hệ thống</h3>
        <p style="color:red;">' . e($error) . '</p>
        <form method="POST" action="/login">
            ' . csrf_field() . '
            Email: <input type="email" name="email" required><br>
            Mật khẩu: <input type="password" name="password" required><br>
            <button type="submit" style="margin-top: 10px;">Đăng nhập</button>
        </form>
        <p>Chưa có tài khoản? <a href="/register">Đăng ký tại đây</a></p>
    </div>';
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

// 5. Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});

// 6. Chuyển hướng /login/product sang trang danh sách sản phẩm chung
Route::redirect('/login/product', '/products');

// 7. Thanh toán & đặt hàng (TM-06 - Customer)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [OrderController::class, 'success'])->name('checkout.success');
});

// 8. Trang Quản trị Admin (/admin) - Chặn Customer bằng CheckAdmin
Route::get('/admin', function () {
    return '
    <!DOCTYPE html>
    <html lang="vi">
    <head><meta charset="UTF-8"><title>Trang Quản Trị Admin</title></head>
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

// 9. Quản lý danh mục & sản phẩm dành riêng cho Admin (TM-11, TM-12)
Route::middleware(['auth', CheckAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);
    });

// 10. Kiểm tra kết nối CSDL
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Kết nối CSDL thành công! Đang sử dụng DB: ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Lỗi kết nối CSDL: ' . $e->getMessage();
    }
});