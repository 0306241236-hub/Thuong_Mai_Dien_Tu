<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Xử lý đặt hàng COD trong 1 Database Transaction.
     * Luồng: Đọc giỏ -> Kiểm tra & khóa tồn kho -> Tạo order -> Tạo order_items & trừ kho -> Xóa giỏ.
     */
    public function placeOrder(int $userId, array $shippingData)
    {
        return DB::transaction(function () use ($userId, $shippingData) {
            $cartItems = DB::table('cart_items')->where('user_id', $userId)->get();

            if ($cartItems->isEmpty()) {
                throw new Exception('Giỏ hàng của bạn đang trống.');
            }

            $totalAmount = 0;
            $validatedItems = [];

            foreach ($cartItems as $item) {
                // Khóa dòng sản phẩm (Pessimistic Locking) để tránh lỗi đặt hàng đồng thời
                $product = DB::table('products')->where('id', $item->product_id)->lockForUpdate()->first();

                if (!$product) {
                    throw new Exception("Sản phẩm ID #{$item->product_id} không tồn tại.");
                }

                $currentStock = $product->stock ?? 0;
                if ($currentStock < $item->quantity) {
                    throw new Exception("Sản phẩm '{$product->name}' chỉ còn {$currentStock} quyển trong kho.");
                }

                $totalAmount += $product->price * $item->quantity;
                $validatedItems[] = [
                    'product_id' => $product->id,
                    'quantity'   => $item->quantity,
                    'price'      => $product->price,
                    'new_stock'  => $currentStock - $item->quantity,
                ];
            }

            $orderId = DB::table('orders')->insertGetId([
                'user_id'          => $userId,
                'receiver_name'    => $shippingData['receiver_name'],
                'shipping_phone'   => $shippingData['shipping_phone'],
                'shipping_address' => $shippingData['shipping_address'],
                'note'             => $shippingData['note'] ?? null,
                'total_amount'     => $totalAmount,
                'payment_method'   => 'COD',
                'status'           => 'pending',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            foreach ($validatedItems as $vItem) {
                DB::table('order_items')->insert([
                    'order_id'   => $orderId,
                    'product_id' => $vItem['product_id'],
                    'quantity'   => $vItem['quantity'],
                    'price'      => $vItem['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('products')->where('id', $vItem['product_id'])->update([
                    'stock'      => $vItem['new_stock'],
                    'updated_at' => now(),
                ]);
            }

            DB::table('cart_items')->where('user_id', $userId)->delete();

            return DB::table('orders')->where('id', $orderId)->first();
        });
    }
}