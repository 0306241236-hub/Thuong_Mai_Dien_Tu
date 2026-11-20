<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng (Thanh toán COD)</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f6fa; margin: 0; padding: 24px; color: #2f3640; }
        .container { max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: 1.2fr 1fr; gap: 20px; }
        .card { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        h2 { margin-top: 0; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 12px; }
        .form-group { margin-bottom: 14px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; font-size: 14px; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #dcdde1; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        .btn { background: #27ae60; color: #fff; border: none; padding: 12px 20px; border-radius: 6px; font-size: 15px; font-weight: bold; cursor: pointer; width: 100%; }
        .btn:hover { background: #219150; }
        .alert-error { background: #ffeaa7; border-left: 4px solid #d63031; color: #c0392b; padding: 12px; margin-bottom: 16px; border-radius: 4px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 10px 6px; border-bottom: 1px solid #eee; text-align: left; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; font-size: 16px; color: #e84118; }
        .back-link { display: inline-block; margin-bottom: 16px; color: #2980b9; text-decoration: none; font-size: 14px; }
        @media (max-width: 768px) { .container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div style="max-width: 900px; margin: 0 auto;">
        <a href="{{ url('/') }}" class="back-link">&larr; Quay lại trang chủ</a>

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="container">
        <!-- Cột trái: Thông tin nhận hàng -->
        <div class="card">
            <h2>Thông tin giao hàng</h2>
            @if($cartItems->isEmpty())
                <div class="alert-error">Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ trước khi đặt hàng.</div>
            @else
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="receiver_name">Họ và tên người nhận *</label>
                        <input type="text" id="receiver_name" name="receiver_name"
                               value="{{ old('receiver_name', $user->full_name ?? $user->name ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="receiver_phone">Số điện thoại nhận hàng *</label>
                        <input type="text" id="receiver_phone" name="receiver_phone"
                               value="{{ old('receiver_phone', $user->phone ?? '') }}" placeholder="VD: 0901234567" required>
                    </div>

                    <div class="form-group">
                        <label for="shipping_address">Địa chỉ nhận hàng *</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3"
                                  placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="note">Ghi chú đơn hàng (tùy chọn)</label>
                        <input type="text" id="note" name="note" value="{{ old('note') }}" placeholder="VD: Giao giờ hành chính">
                    </div>

                    <p style="font-size: 13px; color: #7f8c8d;">Phương thức thanh toán: <strong>Thanh toán khi nhận hàng (COD)</strong></p>

                    <button type="submit" class="btn">Xác nhận đặt hàng</button>
                </form>
            @endif
        </div>

        <!-- Cột phải: Tóm tắt giỏ hàng -->
        <div class="card">
            <h2>Tóm tắt giỏ hàng</h2>
            @if($cartItems->isEmpty())
                <p style="color: #7f8c8d; font-size: 14px;">Chưa có sản phẩm nào trong giỏ.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-right">SL</th>
                            <th class="text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    {{ $item->product_name }}<br>
                                    <small style="color:#7f8c8d;">{{ number_format($item->price, 0, ',', '.') }} đ</small>
                                </td>
                                <td class="text-right">x{{ $item->quantity }}</td>
                                <td class="text-right">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="2">Tổng thanh toán</td>
                            <td class="text-right">{{ number_format($totalAmount, 0, ',', '.') }} đ</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>