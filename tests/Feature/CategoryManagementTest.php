<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

  public function test_admin_can_crud_empty_category(): void
{
        $admin = new User();
        $admin->id = 1;
        $admin->role = 'admin';
        $this->actingAs($admin);

// 1. Tạo mới
        $response = $this->post(route('admin.categories.store'), [
            'name' => 'Sách Lịch Sử',
            'description' => 'Các đầu sách lịch sử Việt Nam và thế giới',
        ]);
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Sách Lịch Sử',
            'slug' => 'sach-lich-su',
        ]);

        $category = Category::first();

        // 2. Xem danh sách
        $this->get(route('admin.categories.index'))
            ->assertStatus(200)
            ->assertSee('Sách Lịch Sử');

        // 3. Cập nhật
        $this->put(route('admin.categories.update', $category), [
            'name' => 'Sách Lịch Sử & Địa Lý',
            'description' => 'Mô tả đã cập nhật',
        ])->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Sách Lịch Sử & Địa Lý',
            'slug' => 'sach-lich-su-dia-ly',
        ]);

        // 4. Xóa danh mục rỗng thành công
        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

  public function test_cannot_delete_category_that_contains_products(): void
    {
        $admin = new User();
        $admin->id = 1;
        $admin->role = 'admin';
        $this->actingAs($admin);

        $category = Category::create([
            'name' => 'Văn học Việt Nam',
            'slug' => 'van-hoc-viet-nam',
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Số Đỏ',
            'author' => 'Vũ Trọng Phụng',
            'price' => 65000,
            'stock' => 10,
        ]);

        $response = $this->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}