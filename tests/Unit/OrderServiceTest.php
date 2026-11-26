<?php

namespace Tests\Unit;

use App\Services\OrderService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    private function createTestUser(?string $email = null): int
    {
        $data = [
            'email'    => $email ?? ('customer_' . uniqid() . '@example.com'),
            'password' => Hash::make('Password123!'),
        ];

        if (Schema::hasColumn('users', 'name')) {
            $data['name'] = 'Nguyễn Văn A';
        }
        if (Schema::hasColumn('users', 'full_name')) {
            $data['full_name'] = 'Nguyễn Văn A';
        }
        if (Schema::hasColumn('users', 'username')) {
            $data['username'] = 'user_' . uniqid();
        }
        if (Schema::hasColumn('users', 'role')) {
            $data['role'] = 'customer';
        }
        if (Schema::hasColumn('users', 'created_at')) {
            $data['created_at'] = now();
            $data['updated_at'] = now();
        }

        return DB::table('users')->insertGetId($data);
    }

    private function createProduct(string $title, int $price, int $stock): int
    {
        $nameCol  = Schema::hasColumn('products', 'name') ? 'name' : 'title';
        $stockCol = Schema::hasColumn('products', 'stock') ? 'stock' : 'quantity';

        $data = [
            $nameCol  => $title,
            'price'   => $price,
            $stockCol => $stock,
        ];

        if (Schema::hasColumn('products', 'author')) {
            $data['author'] = 'Tác giả Test';
        }

        if (Schema::hasColumn('products', 'slug')) {
            $data['slug'] = Str::slug($title) . '-' . uniqid();
        }

        if (Schema::hasColumn('products', 'category_id') && Schema::hasTable('categories')) {
            $categoryId = DB::table('categories')->value('id');
            if (!$categoryId) {
                $catNameCol = Schema::hasColumn('categories', 'name') ? 'name' : 'title';
                $catData = [$catNameCol => 'Sách Lập Trình'];
                if (Schema::hasColumn('categories', 'slug')) {
                    $catData['slug'] = 'sach-lap-trinh-' . uniqid();
                }
                if (Schema::hasColumn('categories', 'created_at')) {
                    $catData['created_at'] = now();
                    $catData['updated_at'] = now();
                }
                $categoryId = DB::table('categories')->insertGetId($catData);
            }
            $data['category_id'] = $categoryId;
        }

        if (Schema::hasColumn('products', 'created_at')) {
            $data['created_at'] = now();
            $data['updated_at'] = now();
        }

        return DB::table('products')->insertGetId($data);
    }

    private function addToCart(int $userId, int $productId, int $quantity): void
    {
        $row = [
            'user_id'    => $userId,
            'product_id' => $productId,
            'quantity'   => $quantity,
        ];

        if (Schema::hasColumn('cart_items', 'created_at')) {
            $row['created_at'] = now();
            $row['updated_at'] = now();
        }

        DB::table('cart_items')->insert($row);
    }

    /**
     * Test 1: Đặt hàng thành công -> trạng thái pending (Chờ xác nhận), trừ kho, xóa giỏ hàng
     */
    public function test_place_order_successfully(): void
    {
        $userId    = $this->createTestUser();
        $productId = $this->createProduct('Sách Laravel Thực Chiến', 150000, 10);

        $this->addToCart($userId, $productId, 2);

        $order = $this->orderService->placeOrder($userId, [
            'receiver_name'    => 'Nguyễn Văn A',
            'receiver_phone'   => '0901234567',
            'shipping_address' => '123 Đường Lê Lợi, TP.HCM',
            'note'             => 'Giao giờ hành chính',
        ]);

        // 1. Đơn hàng được tạo với trạng thái pending (Chờ xác nhận)
        $this->assertDatabaseHas('orders', [
            'id'      => $order->id,
            'user_id' => $userId,
            'status'  => 'pending',
        ]);

        // 2. Chi tiết đơn hàng khớp số lượng đặt
        $this->assertDatabaseHas('order_items', [
            'order_id'   => $order->id,
            'product_id' => $productId,
            'quantity'   => 2,
        ]);

        // 3. Tồn kho giảm từ 10 xuống 8
        $stockCol = Schema::hasColumn('products', 'stock') ? 'stock' : 'quantity';
        $this->assertDatabaseHas('products', [
            'id'      => $productId,
            $stockCol => 8,
        ]);

        // 4. Giỏ hàng của user được xóa sạch
        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $userId,
        ]);
    }

    /**
     * Test 2: Đặt vượt tồn kho bị từ chối & rollback toàn bộ giao dịch
     */
    public function test_place_order_exceeding_stock_throws_exception_and_rollbacks(): void
    {
        $userId   = $this->createTestUser();
        $productA = $this->createProduct('Sách A (Đủ kho)', 100000, 5);
        $productB = $this->createProduct('Sách B (Thiếu kho)', 200000, 1);

        $this->addToCart($userId, $productA, 2);
        $this->addToCart($userId, $productB, 3);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('không đủ tồn kho');

        try {
            $this->orderService->placeOrder($userId, [
                'receiver_name'    => 'Nguyễn Văn A',
                'receiver_phone'   => '0901234567',
                'shipping_address' => '123 Đường Lê Lợi, TP.HCM',
            ]);
        } finally {
            $this->assertDatabaseCount('orders', 0);
            $this->assertDatabaseCount('order_items', 0);

            $stockCol = Schema::hasColumn('products', 'stock') ? 'stock' : 'quantity';
            $this->assertDatabaseHas('products', ['id' => $productA, $stockCol => 5]);
            $this->assertDatabaseHas('products', ['id' => $productB, $stockCol => 1]);
            $this->assertDatabaseCount('cart_items', 2);
        }
    }

    /**
     * Test 3 (TM-NFR1): 2 khách hàng cùng đặt 1 cuốn sách cuối -> chỉ 1 đơn thành công, tồn kho = 0 (không âm)
     */
    public function test_only_one_order_succeeds_for_last_item_and_stock_never_negative(): void
    {
        $user1Id    = $this->createTestUser('khach1@example.com');
        $user2Id    = $this->createTestUser('khach2@example.com');
        $lastBookId = $this->createProduct('Sách Giới Hạn (Còn 1 cuốn)', 120000, 1);

        $this->addToCart($user1Id, $lastBookId, 1);
        $this->addToCart($user2Id, $lastBookId, 1);

        $shipping = [
            'receiver_name'    => 'Khách Hàng',
            'receiver_phone'   => '0909999999',
            'shipping_address' => 'Đồng Nai',
        ];

        // Phiên 1 đặt thành công
        $order1 = $this->orderService->placeOrder($user1Id, $shipping);
        $this->assertNotNull($order1->id);

        // Phiên 2 đặt ngay sau đó -> phải bị từ chối
        $secondOrderFailed = false;
        try {
            $this->orderService->placeOrder($user2Id, $shipping);
        } catch (Exception $e) {
            $secondOrderFailed = true;
        }

        $this->assertTrue($secondOrderFailed, 'Phiên đặt hàng thứ 2 phải bị từ chối khi hết sách.');
        $this->assertDatabaseCount('orders', 1);

        $stockCol = Schema::hasColumn('products', 'stock') ? 'stock' : 'quantity';
        $this->assertDatabaseHas('products', [
            'id'      => $lastBookId,
            $stockCol => 0,
        ]);
    }
}