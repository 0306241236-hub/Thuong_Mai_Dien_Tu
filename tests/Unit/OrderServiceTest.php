<?php

namespace Tests\Unit;

use App\Services\OrderService;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    /**
     * Tạo nhanh dữ liệu mẫu (User + Product) phục vụ Unit Test
     */
    private function seedTestData(int $initialStock = 10): array
    {
        $userId = DB::table('users')->insertGetId([
            'full_name'  => 'Khach Hang Test',
            'email'      => 'test_order_' . uniqid() . '@gmail.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'customer',
            'status'     => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $stockColumn = Schema::hasColumn('products', 'stock') ? 'stock' : 'quantity';
        $nameColumn  = Schema::hasColumn('products', 'name') ? 'name' : 'title';

        $productData = [
            $nameColumn  => 'Sách Lập Trình Laravel',
            'price'      => 150000,
            $stockColumn => $initialStock,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Bổ sung các cột có thể bắt buộc trong CSDL của bạn
        if (Schema::hasColumn('products', 'slug')) {
            $productData['slug'] = 'sach-lap-trinh-laravel-' . uniqid();
        }
        if (Schema::hasColumn('products', 'author')) {
            $productData['author'] = 'Tác giả Test';
        }
        if (Schema::hasColumn('products', 'description')) {
            $productData['description'] = 'Mô tả test';
        }

        if (Schema::hasColumn('products', 'category_id')) {
            $categoryId = DB::table('categories')->value('id');
            if (!$categoryId) {
                $categoryData = [
                    'name'       => 'Danh mục test',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if (Schema::hasColumn('categories', 'slug')) {
                    $categoryData['slug'] = 'danh-muc-test-' . uniqid();
                }
                $categoryId = DB::table('categories')->insertGetId($categoryData);
            }
            $productData['category_id'] = $categoryId;
        }

        $productId = DB::table('products')->insertGetId($productData);

        return [$userId, $productId, $stockColumn];
    }

    /**
     * Test case 1: Đặt hàng thành công trong transaction
     */
    public function test_place_order_successfully(): void
    {
        [$userId, $productId, $stockColumn] = $this->seedTestData(10);

        DB::table('cart_items')->insert([
            'user_id'    => $userId,
            'product_id' => $productId,
            'quantity'   => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $shippingData = [
            'receiver_name'    => 'Nguyễn Văn A',
            'shipping_phone'   => '0901234567',
            'shipping_address' => '123 Đường Lê Lợi, TP.HCM',
            'note'             => 'Giao giờ hành chính',
        ];

        $order = $this->orderService->placeOrder($userId, $shippingData);

        $this->assertNotNull($order);
        $this->assertEquals('Chờ xác nhận', $order->status);
        $this->assertEquals(450000, $order->total_amount);

        $this->assertDatabaseHas('order_items', [
            'order_id'   => $order->id,
            'product_id' => $productId,
            'quantity'   => 3,
        ]);

        $this->assertDatabaseHas('products', [
            'id'         => $productId,
            $stockColumn => 7,
        ]);

        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $userId,
        ]);
    }

    /**
     * Test case 2: Đặt vượt tồn kho bị từ chối và rollback toàn bộ
     */
    public function test_place_order_exceeding_stock_throws_exception_and_rollbacks(): void
    {
        [$userId, $productId, $stockColumn] = $this->seedTestData(2);

        DB::table('cart_items')->insert([
            'user_id'    => $userId,
            'product_id' => $productId,
            'quantity'   => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $shippingData = [
            'receiver_name'    => 'Nguyễn Văn B',
            'shipping_phone'   => '0909876543',
            'shipping_address' => '456 Đường Nguyễn Huệ, TP.HCM',
        ];

        try {
            $this->orderService->placeOrder($userId, $shippingData);
            $this->fail('Lẽ ra phải ném ngoại lệ khi đặt vượt tồn kho.');
        } catch (Exception $e) {
            $this->assertStringContainsString('không đủ tồn kho', $e->getMessage());
        }

        $this->assertDatabaseMissing('orders', [
            'user_id' => $userId,
        ]);

        $this->assertDatabaseHas('products', [
            'id'         => $productId,
            $stockColumn => 2,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'user_id'    => $userId,
            'product_id' => $productId,
            'quantity'   => 5,
        ]);
    }
}