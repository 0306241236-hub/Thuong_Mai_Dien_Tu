@extends('layouts.app')

@section('title', 'Trang chủ - Sách Sinh Viên')

@section('content')
    <!-- 1. Khối tìm kiếm chính -->
    <section class="mb-5">
        <h1 class="fw-bold fs-2 mb-1">Tìm sách cho học kỳ của bạn</h1>
        <p class="text-secondary mb-4">Giáo trình, sách tham khảo và kỹ năng dành cho sinh viên.</p>

        <form action="{{ url('/products') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="keyword" class="form-control form-control-lg fs-6" placeholder="Nhập tên sách, tác giả hoặc môn học...">
            <button type="submit" class="btn btn-wireframe px-4 fw-medium text-nowrap">Tìm kiếm</button>
        </form>
    </section>

    <!-- 2. Khối khám phá theo danh mục (Dữ liệu thật từ CSDL) -->
    <section class="mb-5">
        <h2 class="fw-bold fs-5 mb-3">Khám phá theo danh mục</h2>
        <div class="row row-cols-2 row-cols-md-5 g-3">
            @forelse ($categories as $cat)
                <div class="col">
                    <a href="{{ url('/products?category=' . $cat->slug) }}" class="text-decoration-none text-dark">
                        <div class="p-3 bg-light border rounded-2 h-100">
                            <div class="fw-semibold small mb-1">{{ $cat->name }}</div>
                            <div class="text-secondary" style="font-size: 0.8rem;">{{ $cat->products_count ?? 0 }} đầu sách</div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-secondary small mb-0">Chưa có danh mục nào trong cơ sở dữ liệu.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 3. Khối 8 Sách mới nhất (Dữ liệu thật từ CSDL) -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold fs-5 m-0">Sách mới cập nhật</h2>
            <a href="{{ url('/products?sort=newest') }}" class="text-dark small text-decoration-underline">Xem tất cả sách &rarr;</a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            @forelse ($newBooks as $book)
                <div class="col">
                    @include('partials.product-card', ['book' => $book])
                </div>
            @empty
                <div class="col-12">
                    <p class="text-secondary small mb-0">Chưa có sách mới nào.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 4. Khối Sách theo từng danh mục (Dữ liệu thật từ CSDL) -->
    @foreach ($categoriesWithBooks as $cat)
        @if ($cat->products->isNotEmpty())
            <section class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="fw-bold fs-5 m-0">{{ $cat->name }}</h2>
                    <a href="{{ url('/products?category=' . $cat->slug) }}" class="text-dark small text-decoration-underline">Xem thêm &rarr;</a>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                    @foreach ($cat->products as $book)
                        <div class="col">
                            @include('partials.product-card', ['book' => $book])
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach
@endsection