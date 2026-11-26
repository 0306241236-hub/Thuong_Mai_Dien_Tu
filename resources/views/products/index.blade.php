@extends('layouts.app')

@section('title', 'Danh sách sách - Sách Sinh Viên')

@section('content')
    <!-- Tiêu đề & Thanh tìm kiếm nhanh -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="fw-bold fs-3 mb-1">Danh mục sách & Giáo trình</h1>
            <p class="text-secondary small mb-0">Hiển thị {{ count($books) }} đầu sách phù hợp</p>
        </div>

        <!-- Nút mở bộ lọc trên điện thoại (360px) -->
        <button class="btn btn-outline-dark btn-sm d-lg-none align-self-start" type="button" data-bs-toggle="collapse" data-bs-target="#filterSidebar">
            Bộ lọc tìm kiếm &#9776;
        </button>
    </div>

    <div class="row g-4">
        <!-- Cột trái: Bộ lọc (Thu gọn trên mobile, hiện cố định trên desktop) -->
        <aside class="col-12 col-lg-3 collapse d-lg-block" id="filterSidebar">
            <form action="{{ url('/products') }}" method="GET" class="border rounded-2 p-3 bg-white">
                <h2 class="fw-bold fs-6 mb-3 pb-2 border-bottom">Bộ lọc sách</h2>

                <!-- Từ khóa -->
                <div class="mb-3">
                    <label for="keyword" class="form-label small fw-semibold">Từ khóa</label>
                    <input type="text" id="keyword" name="keyword" value="{{ request('keyword') }}" class="form-control form-control-sm" placeholder="Tên sách, tác giả...">
                </div>

                <!-- Danh mục -->
                <div class="mb-3">
                    <label for="category" class="form-label small fw-semibold">Danh mục</label>
                    <select id="category" name="category" class="form-select form-select-sm">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['slug'] }}" {{ request('category') == $cat['slug'] ? 'selected' : '' }}>
                                {{ $cat['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Khoảng giá -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Khoảng giá (VNĐ)</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control form-control-sm" placeholder="Từ" min="0" step="5000">
                        <span class="text-secondary">-</span>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control form-control-sm" placeholder="Đến" min="0" step="5000">
                    </div>
                </div>

                <!-- Sắp xếp -->
                <div class="mb-4">
                    <label for="sort" class="form-label small fw-semibold">Sắp xếp theo</label>
                    <select id="sort" name="sort" class="form-select form-select-sm">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-wireframe btn-sm py-2 fw-medium">Áp dụng bộ lọc</button>
                    <a href="{{ url('/products') }}" class="btn btn-outline-secondary btn-sm">Xóa bộ lọc</a>
                </div>
            </form>
        </aside>

        <!-- Cột phải: Lưới danh sách sách & Phân trang -->
        <div class="col-12 col-lg-9">
            @if (count($books) > 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-4">
                    @foreach ($books as $book)
                        <div class="col">
                            @include('partials.product-card', ['book' => $book])
                        </div>
                    @endforeach
                </div>

                <!-- Khung phân trang tĩnh -->
                <nav aria-label="Phân trang sách" class="d-flex justify-content-center mt-4">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><span class="page-link text-secondary">Trước</span></li>
                        <li class="page-item active"><span class="page-link bg-dark border-dark">1</span></li>
                        <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
                        <li class="page-item"><a class="page-link text-dark" href="#">3</a></li>
                        <li class="page-item"><a class="page-link text-dark" href="#">Sau</a></li>
                    </ul>
                </nav>
            @else
                <div class="border rounded-2 p-5 text-center bg-light">
                    <p class="fw-semibold mb-1">Không tìm thấy cuốn sách nào phù hợp</p>
                    <p class="text-secondary small mb-3">Thử thay đổi từ khóa hoặc xóa bớt điều kiện lọc.</p>
                    <a href="{{ url('/products') }}" class="btn btn-wireframe btn-sm">Xem tất cả sách</a>
                </div>
            @endif
        </div>
    </div>
@endsection