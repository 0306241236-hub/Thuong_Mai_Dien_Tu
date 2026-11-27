<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f6fa; margin: 0; padding: 30px; color: #2f3640; }
        .card { max-width: 650px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); }
        .success-badge { background: #dff9fb; color: #27ae60; border: 1px solid #badc58; padding: 14px; border-radius: 6px; text-align: center; margin-bottom: 20px; }
        .success-badge h1 { margin: 0 0 6px 0; font-size: 22px; }
        .info-list { list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 14px; line-height: 1.8; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; margin-bottom: 20px; }
        th, td { padding: 10px 6px; border-bottom: 1px solid #eee; text-align: left; }
        .text-right { text-align: right; }
        .btn-home { display: inline-block; background: #2980b9; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        @php
            $trangThai = [
                'pending'    => 'Chờ xác nhận',
                'confirmed'  => 'Đã xác nhận',
                'shipping'   => 'Đang giao hàng',
                'delivered'  => 'Đã giao hàng',
                'completed'  => 'Hoàn thành',
                'cancelled'  => 'Đã hủy',
            ];
        @endphp

        <div class="success-badge">
            <h1>Đặt hàng thành công!</h1>
            <div>Mã đơn hàng: <strong>#{{ $order->id }}</strong> &bull; Trạng thái: <strong>{{ $trangThai[$order->status] ?? $order->status }}</strong></div>
        </div>

        <ul class="info-list">
            <li><strong>Người nhận:</strong> {{ $order->receiver_name }}</li>
            <li><strong>Số điện thoại:</strong> {{ $order->receiver_phone }}</li>
            <li><strong>Địa chỉ nhận hàng:</strong> {{ $order->shipping_address }}</li>
            @if(!empty($order->note))
                <li><strong>Ghi chú:</strong> {{ $order->note }}</li>
            @endif
            <li><strong>Hình thức thanh toán:</strong> Thanh toán khi nhận hàng (COD)</li>
        </ul>

        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th class="text-right">SL</th>
                    <th class="text-right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td class="text-right">x{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->item_price * $item->quantity, 0, ',', '.') }} đ</td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold; color: #e84118; font-size: 16px;">
                    <td colspan="2">Tổng cộng</td>
                    <td class="text-right">{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                </tr>
            </tbody>
        </table>

        <div style="text-align: center;">
            <a href="{{ url('/') }}" class="btn-home">Tiếp tục mua sắm</a>
        </div>
    </div>
</body>
</html>