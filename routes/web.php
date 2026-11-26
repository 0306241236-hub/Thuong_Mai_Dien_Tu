<?php

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\CheckAdmin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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

// Giỏ hàng (TM-05)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id?}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

Route::get('/', function () {
    $categories = Category::withCount(['products' => function ($query) {
        $query->where('is_active', true);
    }])->get();

    $newBooks = Product::with('category')
        ->where('is_active', true)
        ->latest()
        ->take(8)
        ->get();

    $categoriesWithBooks = Category::with(['products' => function ($query) {
        $query->where('is_active', true)->latest()->take(4);
    }])->get();

    return view('home', compact('categories', 'newBooks', 'categoriesWithBooks'));
})->name('home');

Route::get('/products', function (Request $request, ProductService $productService) {
    $keyword    = $request->input('keyword');
    $categoryId = $request->filled('category_id') ? (int) $request->input('category_id') : null;
    $minPrice   = $request->filled('min_price') ? (float) $request->input('min_price') : null;
    $maxPrice   = $request->filled('max_price') ? (float) $request->input('max_price') : null;
    $sort       = $request->input('sort', 'newest');
    $page       = max(1, (int) $request->input('page', 1));

    $books = $productService->search($keyword, $categoryId, $minPrice, $maxPrice, $sort, $page);
    $categories = Category::withCount(['products' => function ($q) {
        $q->where('is_active', true);
    }])->get();

    return view('products.index', compact('books', 'categories'));
})->name('products.index');

Route::get('/products/{id}', function ($id) {
    // Lấy thông tin sách đang mở bán kèm danh mục, báo 404 nếu không tồn tại
    $book = Product::with('category')
        ->where('is_active', true)
        ->findOrFail($id);

    // Lấy tối đa 4 cuốn sách cùng danh mục (trừ cuốn hiện tại)
    $relatedBooks = Product::with('category')
        ->where('is_active', true)
        ->where('category_id', $book->category_id)
        ->where('id', '!=', $book->id)
        ->latest()
        ->take(4)
        ->get();

    return view('products.show', compact('book', 'relatedBooks'));
})->whereNumber('id')->name('products.show');

// Giao diện & xử lý Đăng ký
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Giao diện & xử lý Đăng nhập
Route::get('/login', function () {
    return view('auth.login');
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
