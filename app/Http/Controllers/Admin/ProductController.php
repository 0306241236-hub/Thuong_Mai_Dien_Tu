<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

   public function index(Request $request)
    {
        $filters = $request->only(['keyword', 'category_id']);
        $products = $this->productService->getPaginatedProducts($filters, 10);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'filters'));
    }
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        $validated['is_active'] = $request->boolean('is_active');

        $this->productService->createProduct($validated, $request->file('image'));

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Thêm sách mới thành công!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request);
        $validated['is_active'] = $request->boolean('is_active');

        $this->productService->updateProduct($product, $validated, $request->file('image'));

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Cập nhật thông tin sách thành công!');
    }

    public function destroy(Product $product)
    {
        try {
            $this->productService->deleteProduct($product);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Đã xóa sách thành công!');
        } catch (QueryException $e) {
            return redirect()
                ->route('admin.products.index')
                ->with('error', 'Không thể xóa sách này vì đã phát sinh dữ liệu đơn hàng.');
        }
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:150'],
            'publisher'   => ['nullable', 'string', 'max:150'],
            'price' => ['required', 'numeric', 'gt:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['nullable', 'boolean'],
            'image'       => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
        ], [
            'category_id.required' => 'Vui lòng chọn danh mục sách.',
            'name.required'        => 'Tên sách không được để trống.',
            'author.required'      => 'Tên tác giả không được để trống.',
            'price.required'       => 'Giá bán không được để trống.',
            'stock.required'       => 'Số lượng tồn kho không được để trống.',
            'price.numeric'        => 'Giá bán phải là định dạng số.',
            'price.gt'             => 'Giá bán sản phẩm phải lớn hơn 0.',
            'stock.integer'        => 'Số lượng tồn kho phải là số nguyên.',
            'stock.min'            => 'Số lượng tồn kho không được nhỏ hơn 0.',
            'image.mimes'          => 'Ảnh bìa chỉ chấp nhận định dạng JPG hoặc PNG.',
            'image.mimetypes'      => 'Nội dung tệp tải lên không phải ảnh JPG hoặc PNG hợp lệ.',
            'image.max'            => 'Dung lượng ảnh bìa không được vượt quá 2MB.',
        ]);
    }
}