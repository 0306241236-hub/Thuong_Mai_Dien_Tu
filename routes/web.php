<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
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

// Trang chủ hiển thị trạng thái đăng nhập, nút vào Admin và nút Đăng xuất

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
Route::get('/layout-mau', function () {
    return view('sample');
});


// === FRONTEND - TV3 ===
Route::get('/products', function (\Illuminate\Http\Request $request) {
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
});