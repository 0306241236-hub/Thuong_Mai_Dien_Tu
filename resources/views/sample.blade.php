@extends('layouts.app')

@section('title', 'Trang chủ - Sách Sinh Viên')

@section('content')
    <!-- Khối tìm kiếm chính -->
    <section class="mb-5">
        <h1 class="fw-bold fs-2 mb-1">Tìm sách cho học kỳ của bạn</h1>
        <p class="text-secondary mb-4">Giáo trình, sách tham khảo và kỹ năng dành cho sinh viên.</p>

        <form action="{{ url('/products') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="keyword" class="form-control form-control-lg fs-6" placeholder="Nhập tên sách, tác giả hoặc môn học...">
            <button type="submit" class="btn btn-wireframe px-4 fw-medium text-nowrap">Tìm kiếm</button>
        </form>
    </section>

    <!-- Khám phá theo danh mục -->
    <section class="mb-5">
        <h2 class="fw-bold fs-5 mb-3">Khám phá theo danh mục</h2>
        <div class="row row-cols-2 row-cols-md-5 g-3">
            @php
                $categories = [
                    ['name' => 'Công nghệ thông tin', 'count' => 24],
                    ['name' => 'Kinh tế', 'count' => 18],
                    ['name' => 'Toán học', 'count' => 16],
                    ['name' => 'Ngoại ngữ', 'count' => 20],
                    ['name' => 'Kỹ năng', 'count' => 12],
                ];
            @endphp
            @foreach ($categories as $cat)
                <div class="col">
                    <a href="{{ url('/products') }}" class="text-decoration-none text-dark">
                        <div class="p-3 bg-light border rounded-2 h-100">
                            <div class="fw-semibold small mb-1">{{ $cat['name'] }}</div>
                            <div class="text-secondary" style="font-size: 0.8rem;">{{ $cat['count'] }} đầu sách</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Sách nổi bật -->
    <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold fs-5 m-0">Sách nổi bật</h2>
            <a href="{{ url('/products') }}" class="text-dark small text-decoration-underline">Xem tất cả sách &rarr;</a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            @php
                $books = [
                    ['title' => 'Lập trình C cơ bản', 'author' => 'Nguyễn Văn An', 'price' => '85.000 ₫'],
                    ['title' => 'Kinh tế vi mô', 'author' => 'Trần Minh Hà', 'price' => '120.000 ₫'],
                    ['title' => 'Toán cao cấp 1', 'author' => 'Lê Thị Mai', 'price' => '95.000 ₫'],
                    ['title' => 'Tiếng Anh học thuật', 'author' => 'Phạm Thu Trang', 'price' => '110.000 ₫'],
                ];
            @endphp
            @foreach ($books as $book)
                <div class="col">
                    <div class="card h-100 border rounded-2 shadow-none">
                        <div class="p-3 pb-0">
                            <div class="book-cover-placeholder d-flex flex-column align-items-center justify-content-center text-center small">
                                <span>Bìa sách</span>
                                <span>Ảnh minh họa</span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column pt-3">
                            <h3 class="card-title fw-bold fs-6 mb-2">{{ $book['title'] }}</h3>
                            <p class="text-secondary small mb-1 mt-auto">{{ $book['author'] }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">{{ $book['price'] }}</span>
                                <a href="#" class="text-dark small text-decoration-underline">Chi tiết &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection