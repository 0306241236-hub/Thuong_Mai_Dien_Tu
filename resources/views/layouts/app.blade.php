<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sách Sinh Viên - Nhà sách trực tuyến')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            color: #212529;
            background-color: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        /* Nút chính màu đen than giống wireframe */
        .btn-wireframe {
            background-color: #3a3a3a;
            border-color: #3a3a3a;
            color: #ffffff;
        }
        .btn-wireframe:hover {
            background-color: #212529;
            border-color: #212529;
            color: #ffffff;
        }
        /* Khung ảnh bìa sách giữ chỗ */
        .book-cover-placeholder {
            background-color: #e9ecef;
            color: #6c757d;
            height: 170px;
            border-radius: 6px;
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Header dùng chung --}}
    @include('partials.header')

    {{-- Nội dung từng trang --}}
    <main class="flex-grow-1 py-4 py-md-5">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Footer dùng chung --}}
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>