@extends('layouts.app')

@section('title', 'Danh sách sách - Cửa hàng sách')

@section('content')
<div class="container py-4">
    <!-- Tiêu đề & Thanh sắp xếp -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Danh sách sách</h1>
            <p class="text-secondary small mb-0">
                Hiển thị {{ $books->count() }} / {{ $books->total() }} đầu sách
                @if(request('keyword'))
                    cho từ khóa "<strong>{{ request('keyword') }}</strong>"
                @endif
            </p>
        </div>

        <!-- Form sắp xếp nhanh (tự động giữ lại các bộ lọc đang chọn) -->
        <form method="GET" action="{{ url('/products') }}" class="d-flex align-items-center gap-2">
            @if(request('keyword')) <input type="hidden" name="keyword" value="{{ request('keyword') }}"> @endif
            @if(request('category_id')) <input type="hidden" name="category_id" value="{{ request('category_id') }}"> @endif
            @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
            @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif

            <label for="sort" class="small text-secondary text-nowrap mb-0">Sắp xếp:</label>
            <select name="sort" id="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
            </select>
        </form>
    </div>

    <div class="row g-4">
        <!-- Cột trái: Bộ lọc -->
        <div class="col-12 col-lg-3">
            <div class="card border rounded-2 shadow-none">
                <div class="card-body">
                    <h2 class="h6 fw-bold mb-3">Bộ lọc tìm kiếm</h2>
                    <form method="GET" action="{{ url('/products') }}">
                        <!-- Từ khóa -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Từ khóa</label>
                            <input type="text" name="keyword" class="form-control form-control-sm"
                                   placeholder="Tên sách, tác giả..." value="{{ request('keyword') }}">
                        </div>

                        <!-- Danh mục -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Danh mục</label>
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">-- Tất cả danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->products_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Khoảng giá -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Khoảng giá (VNĐ)</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="number" name="min_price" class="form-control form-control-sm"
                                       placeholder="Từ" min="0" step="1000" value="{{ request('min_price') }}">
                                <span>-</span>
                                <input type="number" name="max_price" class="form-control form-control-sm"
                                       placeholder="Đến" min="0" step="1000" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        <!-- Giữ trạng thái sắp xếp hiện tại -->
                        <input type="hidden" name="sort" value="{{ request('sort', 'newest') }}">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-sm">Áp dụng bộ lọc</button>
                            <a href="{{ url('/products') }}" class="btn btn-outline-secondary btn-sm">Xóa bộ lọc</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Cột phải: Lưới sản phẩm (12 sách/trang) -->
        <div class="col-12 col-lg-9">
            @if($books->count() > 0)
                <div class="row row-cols-2 row-cols-md-3 g-3">
                    @foreach($books as $book)
                        <div class="col">
                            @include('partials.product-card', ['book' => $book])
                        </div>
                    @endforeach
                </div>

                <!-- Phân trang (giữ nguyên tham số URL) -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $books->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="border rounded-2 p-5 text-center bg-light">
                    <p class="fw-semibold mb-1">Không tìm thấy cuốn sách nào phù hợp</p>
                    <p class="text-secondary small mb-3">Thử thay đổi từ khóa hoặc xóa bớt điều kiện lọc.</p>
                    <a href="{{ url('/products') }}" class="btn btn-dark btn-sm">Xem tất cả sách</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection