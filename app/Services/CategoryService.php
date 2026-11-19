<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;
use Exception;

class CategoryService
{
    public function getAll(?string $keyword = null, int $perPage = 10)
    {
        return Category::withCount('products')
            ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function create(array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        $data['slug'] = Str::slug($data['name']);
        return $category->update($data);
    }

    public function delete(Category $category): void
    {
        if ($category->products()->count() > 0) {
            throw new Exception('Không thể xóa danh mục "' . $category->name . '" vì đang có ' . $category->products()->count() . ' sản phẩm trực thuộc!');
        }
        $category->delete();
    }
}