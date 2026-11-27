<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CartController extends Controller
{
    // Đồng bộ session('cart') từ bảng cart_items để thanh navbar hiển thị đúng số lượng
    private function syncSessionCart(int $userId): array
    {
        $nameColumn = Schema::hasColumn('products', 'name') ? 'name' : 'title';

        $items = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->where('cart_items.user_id', $userId)
            ->select(
                'cart_items.product_id',
                'cart_items.quantity',
                "products.{$nameColumn} as name",
                'products.price'
            )
            ->get();

        $sessionCart = [];
        foreach ($items as $item) {
            $sessionCart[$item->product_id] = [
                'id'         => $item->product_id,
                'product_id' => $item->product_id,
                'name'       => $item->name,
                'price'      => $item->price,
                'quantity'   => $item->quantity,
            ];
        }

        session()->put('cart', $sessionCart);
        return $sessionCart;
    }

    // 1. Hiển thị trang giỏ hàng (/cart)
    public function index()
    {
        $cart = $this->syncSessionCart(Auth::id());
        $total = 0;

        foreach ($cart as $item) {
            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // 2. Thêm sách vào giỏ hàng (lưu vào bảng cart_items)
    public function add(Request $request, $id = null)
    {
        $userId = Auth::id();
        $productId = $id ?? $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));

        $product = Product::findOrFail($productId);

        $existingItem = DB::table('cart_items')
            ->where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            $updateData = ['quantity' => $existingItem->quantity + $quantity];
            if (Schema::hasColumn('cart_items', 'updated_at')) {
                $updateData['updated_at'] = now();
            }
            DB::table('cart_items')->where('id', $existingItem->id)->update($updateData);
        } else {
            $insertData = [
                'user_id'    => $userId,
                'product_id' => $product->id,
                'quantity'   => $quantity,
            ];
            if (Schema::hasColumn('cart_items', 'created_at')) {
                $insertData['created_at'] = now();
            }
            if (Schema::hasColumn('cart_items', 'updated_at')) {
                $insertData['updated_at'] = now();
            }
            DB::table('cart_items')->insert($insertData);
        }

        $this->syncSessionCart($userId);

        return redirect()->route('cart.index')->with('success', 'Đã thêm "' . $product->name . '" vào giỏ hàng!');
    }

    // 3. Cập nhật số lượng trong bảng cart_items
    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            DB::table('cart_items')
                ->where('user_id', $userId)
                ->where('product_id', $id)
                ->delete();
        } else {
            $updateData = ['quantity' => $quantity];
            if (Schema::hasColumn('cart_items', 'updated_at')) {
                $updateData['updated_at'] = now();
            }
            DB::table('cart_items')
                ->where('user_id', $userId)
                ->where('product_id', $id)
                ->update($updateData);
        }

        $this->syncSessionCart($userId);

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật giỏ hàng.');
    }

    // 4. Xóa 1 sách khỏi bảng cart_items
    public function remove($id)
    {
        $userId = Auth::id();

        DB::table('cart_items')
            ->where('user_id', $userId)
            ->where('product_id', $id)
            ->delete();

        $this->syncSessionCart($userId);

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}