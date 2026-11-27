<header class="bg-white border-bottom sticky-top">
    <!-- Thanh thông tin trên cùng -->
    <div class="bg-light border-bottom py-1 small text-secondary">
        <div class="container d-flex justify-content-between align-items-center">
            <span>Nhà sách trực tuyến dành cho sinh viên</span>
            <div>
                @auth
                    <span class="me-2">Xin chào, <strong class="text-dark">{{ Auth::user()->full_name ?? Auth::user()->name }}</strong></span>
                    <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link btn-sm text-secondary text-decoration-none p-0">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" class="text-secondary text-decoration-none me-2">Đăng nhập</a>
                    <span>·</span>
                    <a href="{{ url('/register') }}" class="text-secondary text-decoration-none ms-2">Đăng ký</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Thanh điều hướng chính -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold fs-4 text-dark m-0 d-inline-flex align-items-center gap-2" href="{{ url('/') }}">
                <img src="{{ asset('images/stack-of-books.png') }}" alt="Logo Sách Sinh Viên" width="32" height="32">
                <span>Sách Sinh Viên</span>
            </a>

            <!-- Nút menu trên điện thoại (360px) -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu bên phải -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
                <ul class="navbar-nav gap-lg-4 mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-1 {{ request()->is('/') || request()->is('layout-mau') ? 'active fw-semibold text-dark border-bottom border-2 border-dark' : 'text-secondary' }}" href="{{ url('/') }}">
                            Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-1 {{ request()->is('products*') ? 'active fw-semibold text-dark border-bottom border-2 border-dark' : 'text-secondary' }}" href="{{ url('/products') }}">
                            Danh mục sách
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-1 {{ request()->is('cart*') ? 'active fw-semibold text-dark border-bottom border-2 border-dark' : 'text-secondary' }}" href="{{ url('/cart') }}">
                            Giỏ hàng ({{ session('cart') ? count(session('cart')) : 0 }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-1 {{ request()->is('admin*') ? 'active fw-semibold text-dark border-bottom border-2 border-dark' : 'text-secondary' }}" href="{{ url('/admin') }}">
                            Quản trị
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>