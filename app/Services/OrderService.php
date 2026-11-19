<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderService
{
    /**
     * Xử lý đặt hàng COD trong 1 Database Transaction.
     *
     * @param int   $userId
     * @param array $shippingData ['receiver_name', 'receiver_phone', 'shipping_address', 'note']
     * @param bool  $simulateError Dùng để kiểm thử rollback khi phát sinh lỗi giữa chừng
     * @return object Đối tượng Order vừa tạo
     * @throws Exception
     */
    public function placeOrder(int $userId, array $shippingData, bool $simulateError = false)
    {
        return DB::transaction(function () use ($userId, $shippingData, $simulateError) {
            // 1. Đọc danh sách sản phẩm trong giỏ hàng
            $cartItems = DB::table('cart_items')
                ->where('user_id', $userId)
                ->get();

            if ($cartItems->isEmpty()) {
                throw new Exception('Giỏ hàng của bạn đang trống, không thể đặt hàng.');
            }

            $totalAmount = 0;
            $validatedItems = [];
            $stockColumn = Schema::hasColumn('products', 'stock') ? 'stock' : 'quantity';
            $nameColumn = Schema::hasColumn('products', 'name') ? 'name' : 'title';

            // 2. Kiểm tra tồn kho & khóa dòng sản phẩm (lockForUpdate)
            foreach ($cartItems as $item) {
                $product = DB::table('products')
                    ->where('id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw new Exception("Sản phẩm ID #{$item->product_id} không tồn tại.");
                }

                $currentStock = (int) ($product->{$stockColumn} ?? 0);
                if ($currentStock <= 0 || $currentStock < $item->quantity) {
                    $productName = $product->{$nameColumn} ?? "ID #{$product->id}";
                    throw new Exception("Sản phẩm '{$productName}' đã hết hàng hoặc không đủ tồn kho (còn {$currentStock}).");
                }

                $unitPrice = (float) $product->price;
                $totalAmount += $unitPrice * $item->quantity;

                $validatedItems[] = [
                    'product_id' => $product->id,
                    'quantity'   => (int) $item->quantity,
                    'price'      => $unitPrice,
                    'new_stock'  => $currentStock - (int) $item->quantity,
                ];
            }

            // 3. Tạo đơn hàng với trạng thái "Chờ xác nhận"
            $phoneValue = $shippingData['receiver_phone'] ?? $shippingData['shipping_phone'] ?? '';

            $orderPayload = [
                'user_id'          => $userId,
                'receiver_name'    => $shippingData['receiver_name'],
                'receiver_phone'   => $phoneValue,
                'shipping_address' => $shippingData['shipping_address'],
                'total_amount'     => $totalAmount,
                'status'           => 'Chờ xác nhận',
                'created_at'       => now(),
                'updated_at'       => now(),
            ];

            if (Schema::hasColumn('orders', 'note')) {
                $orderPayload['note'] = $shippingData['note'] ?? null;
            }
            if (Schema::hasColumn('orders', 'payment_method')) {
                $orderPayload['payment_method'] = 'COD';
            }

            $orderId = DB::table('orders')->insertGetId($orderPayload);

            // Tự thử lỗi giữa chừng sau khi tạo order để kiểm tra cơ chế rollback của transaction
            if ($simulateError) {
                throw new Exception('Lỗi giả lập giữa chừng sau khi tạo đơn hàng để kiểm tra rollback.');
            }

            // 4. Tạo chi tiết đơn hàng (order_items) và trừ tồn kho (tự động khớp tên cột thực tế trong bảng order_items)
            $orderItemColumns = Schema::getColumnListing('order_items');

            foreach ($validatedItems as $vItem) {
                $itemPayload = [
                    'order_id'   => $orderId,
                    'product_id' => $vItem['product_id'],
                    'quantity'   => $vItem['quantity'],
                ];

                // Điền đúng tên cột giá nếu bảng order_items có định nghĩa
                foreach (['price', 'unit_price', 'price_at_purchase', 'sale_price'] as $priceCol) {
                    if (in_array($priceCol, $orderItemColumns)) {
                        $itemPayload[$priceCol] = $vItem['price'];
                    }
                }
                if (in_array('subtotal', $orderItemColumns)) {
                    $itemPayload['subtotal'] = $vItem['price'] * $vItem['quantity'];
                }
                if (in_array('created_at', $orderItemColumns)) {
                    $itemPayload['created_at'] = now();
                }
                if (in_array('updated_at', $orderItemColumns)) {
                    $itemPayload['updated_at'] = now();
                }

                DB::table('order_items')->insert($itemPayload);

                DB::table('products')
                    ->where('id', $vItem['product_id'])
                    ->update([
                        $stockColumn => $vItem['new_stock'],
                        'updated_at' => now(),
                    ]);
            }

            // 5. Xóa giỏ hàng của người dùng sau khi đặt thành công
            DB::table('cart_items')
                ->where('user_id', $userId)
                ->delete();

            return DB::table('orders')->where('id', $orderId)->first();
        });
    }
}