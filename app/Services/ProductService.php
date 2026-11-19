<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function getPaginatedProducts(int $perPage = 10)
    {
        return Product::with('category')
            ->latest('id')
            ->paginate($perPage);
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