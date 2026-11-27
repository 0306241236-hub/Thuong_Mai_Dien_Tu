@extends('layouts.app')

@section('title', $book->name . ' - Cửa hàng sách')

@section('content')
@php
    $stock = data_get($book, 'stock') ?? data_get($book, 'quantity') ?? data_get($book, 'stock_quantity', 0);
    $image = data_get($book, 'image_url') ?? data_get($book, 'image');
@endphp

<div class="container py-4">
    <!-- Đường dẫn điều hướng (Breadcrumb) -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/products') }}" class="text-dark text-decoration-none">Danh mục sách</a></li>
            @if($book->category)
                <li class="breadcrumb-item">
                    <a href="{{ url('/products?category_id=' . $book->category->id) }}" class="text-dark text-decoration-none">
                        {{ $book->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $book->name }}</li>
        </ol>
    </nav>

    <!-- Thông báo khi thêm vào giỏ hàng -->
    @if(session('success'))
        <div class="alert alert-success small py-2 mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger small py-2 mb-4">{{ session('error') }}</div>
    @endif

    <!-- Khối thông tin chi tiết sách -->
    <div class="card border rounded-3 shadow-none mb-5">
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Cột trái: Ảnh bìa sách -->
                <div class="col-12 col-md-4">
                    @if(!empty($image) && file_exists(public_path($image)))
                        <img src="{{ asset($image) }}" alt="{{ $book->name }}"
                             class="w-100 rounded-2 border object-fit-cover" style="max-height: 400px;">
                    @else
                        <div class="border rounded-2 bg-light d-flex flex-column align-items-center justify-content-center text-secondary"
                             style="height: 360px;">
                            <span class="fw-semibold">Bìa sách</span>
                            <span class="small">Ảnh minh họa</span>
                        </div>
                    @endif
                </div>

                <!-- Cột phải: Thông tin & Nút thêm giỏ hàng -->
                <div class="col-12 col-md-8 d-flex flex-column">
                    @if($book->category)
                        <span class="badge bg-light text-dark border align-self-start mb-2">
                            {{ $book->category->name }}
                        </span>
                    @endif

                    <h1 class="h3 fw-bold mb-2">{{ $book->name }}</h1>
                    <p class="text-secondary mb-3">
                        Tác giả: <strong class="text-dark">{{ $book->author ?? 'Đang cập nhật' }}</strong>
                    </p>

                    <!-- Giá bán định dạng 120.000 ₫ -->
                    <div class="bg-light border rounded-2 p-3 mb-3">
                        <span class="h4 fw-bold text-danger mb-0">
                            {{ number_format($book->price, 0, ',', '.') }} ₫
                        </span>
                    </div>

                    <!-- Tình trạng tồn kho -->
                    <div class="mb-4 small">
                        <span class="text-secondary">Tình trạng kho: </span>
                        @if($stock > 0)
                            <span class="fw-semibold text-success">Còn hàng ({{ $stock }} cuốn)</span>
                        @else
                            <span class="fw-semibold text-danger">Tạm hết hàng</span>
                        @endif
                    </div>

                    <!-- Form Thêm vào giỏ hàng (kết nối TM-05) -->
                    @if($stock > 0)
                        <form method="POST" action="{{ url('/cart/add') }}" class="mb-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $book->id }}">

                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="quantity" class="small fw-semibold mb-0">Số lượng:</label>
                                    <input type="number" id="quantity" name="quantity" value="1"
                                           min="1" max="{{ $stock }}"
                                           class="form-control form-control-sm text-center" style="width: 80px;" required>
                                </div>

                                <button type="submit" class="btn btn-dark px-4 fw-semibold">
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="mb-4">
                            <button type="button" class="btn btn-secondary px-4" disabled>Hết hàng</button>
                        </div>
                    @endif

                    <!-- Mô tả sách -->
                    <div class="border-top pt-3 mt-auto">
                        <h2 class="h6 fw-bold mb-2">Mô tả nội dung</h2>
                        <p class="text-secondary small mb-0" style="white-space: pre-line;">
                            {{ $book->description ?: 'Chưa có mô tả chi tiết cho cuốn sách này.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mục Sách cùng danh mục (4 cuốn) -->
    <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 fw-bold mb-0">Sách cùng danh mục</h2>
            @if($book->category)
                <a href="{{ url('/products?category_id=' . $book->category->id) }}" class="text-dark small text-decoration-underline">
                    Xem thêm &rarr;
                </a>
            @endif
        </div>

        @if($relatedBooks->count() > 0)
            <div class="row row-cols-2 row-cols-md-4 g-3">
                @foreach($relatedBooks as $related)
                    <div class="col">
                        @include('partials.product-card', ['book' => $related])
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-secondary small">Chưa có sách khác cùng danh mục.</p>
        @endif
    </section>
</div>
@endsection