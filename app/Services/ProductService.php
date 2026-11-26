<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function search(
        ?string $keyword = null,
        ?int $categoryId = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?string $sort = 'newest',
        int $page = 1
    ): LengthAwarePaginator {
        $query = Product::with('category')
            ->where('is_active', true);

        // 1. Tìm kiếm theo từ khóa (tên sách hoặc tác giả) - dùng tham số hóa
        if (!empty($keyword)) {
            $kw = '%' . trim($keyword) . '%';
            $query->where(function ($q) use ($kw) {
                $q->where('name', 'LIKE', $kw)
                  ->orWhere('author', 'LIKE', $kw);
            });
        }

        // 2. Lọc theo danh mục
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // 3. Lọc theo khoảng giá
        if ($minPrice !== null && $minPrice >= 0) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null && $maxPrice > 0) {
            $query->where('price', '<=', $maxPrice);
        }

        // 4. Sắp xếp
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 5. Phân trang 12 sách/trang và giữ nguyên tham số bộ lọc trên URL
        return $query->paginate(12, ['*'], 'page', $page)->withQueryString();
    }

    public function getPaginatedProducts(array $filters = [], int $perPage = 10)
    {
        $query = Product::with('category');

        if (!empty($filters['keyword'])) {
            $keyword = trim($filters['keyword']);
            $query->where('name', 'like', "%{$keyword}%");
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function createProduct(array $data, ?UploadedFile $imageFile = null): Product
    {
        if ($imageFile) {
            $data['image_url'] = $this->uploadCoverImage($imageFile);
        }

        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data, ?UploadedFile $imageFile = null): Product
    {
        if ($imageFile) {
            $this->deleteCoverImage($product->image_url);
            $data['image_url'] = $this->uploadCoverImage($imageFile);
        }

        $product->update($data);

        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $oldImage = $product->image_url;
        $product->delete();
        $this->deleteCoverImage($oldImage);
    }

    private function uploadCoverImage(UploadedFile $file): string
    {
        // Đổi tên tệp sang UUID ngẫu nhiên, lấy phần mở rộng suy ra từ MIME thực tế
        $fileName = Str::uuid()->toString() . '.' . $file->extension();

        return $file->storeAs('products', $fileName, 'public');
    }

    private function deleteCoverImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}   