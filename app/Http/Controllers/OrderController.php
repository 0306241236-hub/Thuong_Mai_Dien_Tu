<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Hiển thị Form đặt hàng & tóm tắt giỏ hàng
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        // Nhận product_id từ nút "Đặt mua" (/checkout?product_id=...) và lưu vào cart_items
        if ($request->filled('product_id')) {
            $product = DB::table('products')->where('id', $request->product_id)->first();

            if ($product) {
                $existingItem = DB::table('cart_items')
                    ->where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($existingItem) {
                    DB::table('cart_items')
                        ->where('id', $existingItem->id)
                        ->increment('quantity');
                } else {
                    $insertData = [
                        'user_id'    => $user->id,
                        'product_id' => $product->id,
                        'quantity'   => 1,
                    ];

                    if (Schema::hasColumn('cart_items', 'created_at')) {
                        $insertData['created_at'] = now();
                    }
                    if (Schema::hasColumn('cart_items', 'updated_at')) {
                        $insertData['updated_at'] = now();
                    }

                    DB::table('cart_items')->insert($insertData);
                }

                // Chuyển về URL sạch để tránh F5 bị cộng dồn số lượng
                return redirect()->to('/checkout');
            }
        }

        $nameColumn = Schema::hasColumn('products', 'name') ? 'name' : 'title';

        $cartItems = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->where('cart_items.user_id', $user->id)
            ->select(
                'cart_items.id',
                'cart_items.product_id',
                'cart_items.quantity',
                "products.{$nameColumn} as product_name",
                'products.price'
            )
            ->get();

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('orders.checkout', compact('user', 'cartItems', 'totalAmount'));
    }

    /**
     * Xử lý submit Form đặt hàng -> gọi OrderService::placeOrder()
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_name'    => 'required|string|max:255',
            'receiver_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'note'             => 'nullable|string|max:500',
        ], [
            'receiver_name.required'    => 'Vui lòng nhập họ tên người nhận.',
            'receiver_phone.required'   => 'Vui lòng nhập số điện thoại nhận hàng.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ nhận hàng.',
        ]);

        try {
            $order = $this->orderService->placeOrder(Auth::id(), $validated);
            return redirect()->route('checkout.success', ['order' => $order->id]);
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Trang "Đặt hàng thành công"
     */
    public function success($orderId)
    {
        $order = DB::table('orders')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            abort(404);
        }

        $nameColumn = Schema::hasColumn('products', 'name') ? 'name' : 'title';
        $orderItemColumns = Schema::getColumnListing('order_items');
        $priceCol = null;

        foreach (['price', 'unit_price', 'price_at_purchase', 'sale_price'] as $col) {
            if (in_array($col, $orderItemColumns)) {
                $priceCol = $col;
                break;
            }
        }

        $selects = [
            'order_items.product_id',
            'order_items.quantity',
            "products.{$nameColumn} as product_name",
            $priceCol ? "order_items.{$priceCol} as item_price" : 'products.price as item_price',
        ];

        $orderItems = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('order_items.order_id', $order->id)
            ->select($selects)
            ->get();

        return view('orders.success', compact('order', 'orderItems'));
    }
}