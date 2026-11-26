<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OrderService
{
    public function placeOrder(int $userId, array $shippingData = []): object
    {
        return DB::transaction(function () use ($userId, $shippingData) {
            $cartItems = DB::table('cart_items')
                ->where('user_id', $userId)
                ->get();

            if ($cartItems->isEmpty()) {
                throw new Exception('Giỏ hàng của bạn đang trống.');
            }

            $nameColumn  = Schema::hasColumn('products', 'name') ? 'name' : 'title';
            $stockColumn = Schema::hasColumn('products', 'stock') ? 'stock' : 'quantity';

            $totalAmount = 0;
            $validatedItems = [];

            foreach ($cartItems as $item) {
                $product = DB::table('products')
                    ->where('id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw new Exception("Sản phẩm ID #{$item->product_id} không tồn tại.");
                }

                $productName  = $product->{$nameColumn} ?? "SP #{$product->id}";
                $currentStock = (int) ($product->{$stockColumn} ?? 0);

                if ($item->quantity <= 0) {
                    throw new Exception("Số lượng đặt của '{$productName}' không hợp lệ.");
                }

                if ($currentStock < $item->quantity) {
                    throw new Exception(
                        "Sản phẩm '{$productName}' không đủ tồn kho (còn {$currentStock}, yêu cầu {$item->quantity})."
                    );
                }

                $totalAmount += $product->price * $item->quantity;

                $validatedItems[] = [
                    'product_id'   => $product->id,
                    'product_name' => $productName,
                    'quantity'     => $item->quantity,
                    'price'        => $product->price,
                ];
            }

            $orderColumns = Schema::getColumnListing('orders');
            $orderData = [
                'user_id' => $userId,
                'status'  => 'pending', // Trạng thái "Chờ xác nhận" theo enum bảng orders
            ];

            if (in_array('order_code', $orderColumns)) {
                $orderData['order_code'] = 'ORD-' . date('YmdHis') . '-' . strtoupper(Str::random(4));
            }
            if (in_array('total_price', $orderColumns)) {
                $orderData['total_price'] = $totalAmount;
            }
            if (in_array('total_amount', $orderColumns)) {
                $orderData['total_amount'] = $totalAmount;
            }
            if (in_array('receiver_name', $orderColumns)) {
                $orderData['receiver_name'] = $shippingData['receiver_name'] ?? $shippingData['name'] ?? 'Khách hàng';
            }
            if (in_array('receiver_phone', $orderColumns)) {
                $orderData['receiver_phone'] = $shippingData['receiver_phone'] ?? $shippingData['phone'] ?? '0000000000';
            }
            if (in_array('shipping_address', $orderColumns)) {
                $orderData['shipping_address'] = $shippingData['shipping_address'] ?? $shippingData['address'] ?? '';
            }
            if (in_array('note', $orderColumns)) {
                $orderData['note'] = $shippingData['note'] ?? null;
            }
            if (in_array('created_at', $orderColumns)) {
                $orderData['created_at'] = now();
            }
            if (in_array('updated_at', $orderColumns)) {
                $orderData['updated_at'] = now();
            }

            $orderId = DB::table('orders')->insertGetId($orderData);

            $orderItemColumns = Schema::getColumnListing('order_items');
            $priceCol = null;
            foreach (['price', 'unit_price', 'price_at_purchase', 'sale_price'] as $col) {
                if (in_array($col, $orderItemColumns)) {
                    $priceCol = $col;
                    break;
                }
            }

            foreach ($validatedItems as $vItem) {
                $itemRow = [
                    'order_id'   => $orderId,
                    'product_id' => $vItem['product_id'],
                    'quantity'   => $vItem['quantity'],
                ];

                if ($priceCol) {
                    $itemRow[$priceCol] = $vItem['price'];
                }
                if (in_array('product_name', $orderItemColumns)) {
                    $itemRow['product_name'] = $vItem['product_name'];
                }
                if (in_array('subtotal', $orderItemColumns)) {
                    $itemRow['subtotal'] = $vItem['price'] * $vItem['quantity'];
                }
                if (in_array('created_at', $orderItemColumns)) {
                    $itemRow['created_at'] = now();
                }
                if (in_array('updated_at', $orderItemColumns)) {
                    $itemRow['updated_at'] = now();
                }

                DB::table('order_items')->insert($itemRow);

                $affected = DB::table('products')
                    ->where('id', $vItem['product_id'])
                    ->where($stockColumn, '>=', $vItem['quantity'])
                    ->decrement($stockColumn, $vItem['quantity']);

                if ($affected === 0) {
                    throw new Exception(
                        "Sản phẩm '{$vItem['product_name']}' vừa hết hàng, giao dịch đã được hoàn tác."
                    );
                }
            }

            DB::table('cart_items')->where('user_id', $userId)->delete();

            return (object) array_merge(['id' => $orderId], $orderData);
        });
    }
}