@extends('layouts.app')

@section('title', 'Giỏ hàng - Sách Sinh Viên')

@section('content')
<div class="container py-3 py-md-4">
    <!-- Tiêu đề & Nút quay lại -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Giỏ hàng của bạn</h1>
            <p class="text-secondary small mb-0">Kiểm tra lại sách và số lượng trước khi đặt hàng</p>
        </div>
        <a href="{{ url('/products') }}" class="btn btn-outline-dark btn-sm text-nowrap">← Tiếp tục chọn sách</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success small py-2">{{ session('success') }}</div>
    @endif

    @if (empty($cart))
        <div class="card border rounded-3 shadow-sm">
            <div class="card-body text-center py-5">
                <p class="text-secondary mb-3">Giỏ hàng của bạn hiện đang trống.</p>
                <a href="{{ url('/products') }}" class="btn btn-dark">Khám phá danh mục sách</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            <!-- Cột danh sách sách -->
            <div class="col-12 col-lg-8">

                <!-- 1. Giao diện Bảng cho màn hình lớn (Desktop/Tablet >= 768px) -->
                <div class="card border rounded-3 shadow-sm d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-center" style="width: 140px;">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $id => $item)
                                    @php
                                        $price = $item['price'] ?? 0;
                                        $qty = $item['quantity'] ?? 1;
                                        $subtotal = $price * $qty;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $item['name'] ?? $item['title'] ?? 'Sách #' . $id }}</div>
                                        </td>
                                        <td class="text-end text-nowrap">
                                            {{ number_format($price, 0, ',', '.') }} đ
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex justify-content-center gap-1">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $qty }}" min="1" max="99"
                                                       class="form-control form-control-sm text-center" style="width: 65px;">
                                                <button type="submit" class="btn btn-outline-secondary btn-sm">Lưu</button>
                                            </form>
                                        </td>
                                        <td class="text-end fw-semibold text-nowrap">
                                            {{ number_format($subtotal, 0, ',', '.') }} đ
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-decoration-none btn-sm p-0">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Giao diện Thẻ xếp dọc gọn gàng cho Điện thoại (< 768px) -->
                <div class="d-md-none d-flex flex-column gap-3">
                    @foreach ($cart as $id => $item)
                        @php
                            $price = $item['price'] ?? 0;
                            $qty = $item['quantity'] ?? 1;
                            $subtotal = $price * $qty;
                        @endphp
                        <div class="card border rounded-3 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <div class="fw-semibold text-dark">{{ $item['name'] ?? $item['title'] ?? 'Sách #' . $id }}</div>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-decoration-none btn-sm p-0 text-nowrap">Xóa</button>
                                    </form>
                                </div>

                                <div class="small text-secondary mb-3">
                                    Đơn giá: <span class="text-dark fw-medium">{{ number_format($price, 0, ',', '.') }} đ</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center gap-1">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $qty }}" min="1" max="99"
                                               class="form-control form-control-sm text-center" style="width: 60px;">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Lưu</button>
                                    </form>

                                    <div class="text-end">
                                        <span class="small text-secondary d-block" style="font-size: 0.75rem;">Thành tiền</span>
                                        <span class="fw-bold text-dark">{{ number_format($subtotal, 0, ',', '.') }} đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <!-- Khung tóm tắt & nút sang Checkout -->
            <div class="col-12 col-lg-4">
                <div class="card border rounded-3 shadow-sm">
                    <div class="card-body p-3 p-md-4">
                        <h2 class="h6 fw-bold border-bottom pb-3 mb-3">Tóm tắt đơn hàng</h2>

                        <div class="d-flex justify-content-between small text-secondary mb-2">
                            <span>Tổng số lượng:</span>
                            <span>{{ array_sum(array_column($cart, 'quantity')) }} cuốn</span>
                        </div>

                        <div class="d-flex justify-content-between fw-bold fs-6 border-top pt-3 mb-4">
                            <span>Tổng cộng:</span>
                            <span class="text-dark">{{ number_format($total, 0, ',', '.') }} đ</span>
                        </div>

                        <div class="d-grid">
                            <a href="{{ url('/checkout') }}" class="btn btn-dark fw-semibold">Tiến hành đặt hàng →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection