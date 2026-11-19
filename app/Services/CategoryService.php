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
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        $data['slug'] = $this->generateUniqueSlug($data['name'], $category->id);
        return $category->update($data);
    }

    public function delete(Category $category): void
    {
        if ($category->products()->count() > 0) {
            throw new Exception('Không thể xóa danh mục "' . $category->name . '" vì đang có ' . $category->products()->count() . ' sản phẩm trực thuộc!');
        }
        $category->delete();
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $count = 1;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $count++;
        }

        return $slug;
    }
}