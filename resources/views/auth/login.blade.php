<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Sách Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Form đăng nhập -->
    <main class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-9 col-md-6 col-lg-4">
                <div class="card border rounded-3 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h1 class="h4 fw-bold mb-1">Đăng nhập</h1>
                            <p class="text-secondary small mb-0">Chào mừng bạn quay trở lại</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success small py-2">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger small py-2">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ url('/login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold">Email</label>
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold">Mật khẩu</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Nhập mật khẩu" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-dark fw-semibold">Đăng nhập</button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <p class="text-center small text-secondary mb-0">
                            Chưa có tài khoản?
                            <a href="{{ url('/register') }}" class="text-dark fw-semibold text-decoration-underline">Đăng ký ngay</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>