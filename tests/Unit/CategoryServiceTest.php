<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\CategoryService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private CategoryService $categoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryService = new CategoryService();
    }

    public function test_khong_the_xoa_danh_muc_dang_co_san_pham(): void
    {
        $category = $this->categoryService->create([
            'name' => 'Sách Lập Trình',
            'description' => 'Danh mục dùng để kiểm thử',
        ]);

        Product::forceCreate([
            'category_id' => $category->id,
            'name' => 'Clean Code',
            'author' => 'Robert C. Martin',
            'price' => 250000,
            'stock' => 10,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Không thể xóa danh mục "Sách Lập Trình" vì đang có 1 sản phẩm trực thuộc!');

        try {
            $this->categoryService->delete($category);
        } finally {
            $this->assertDatabaseHas('categories', [
                'id' => $category->id,
            ]);
        }
    }

    public function test_xoa_thanh_cong_danh_muc_khong_co_san_pham(): void
    {
        $category = $this->categoryService->create([
            'name' => 'Danh Mục Trống',
        ]);

        $this->categoryService->delete($category);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}