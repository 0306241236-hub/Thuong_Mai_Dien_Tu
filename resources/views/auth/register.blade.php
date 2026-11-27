<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - Sách Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Form đăng ký -->
    <main class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-9 col-md-6 col-lg-4">
                <div class="card border rounded-3 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h1 class="h4 fw-bold mb-1">Tạo tài khoản mới</h1>
                            <p class="text-secondary small mb-0">Điền thông tin bên dưới để đăng ký</p>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger small py-2">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ url('/register') }}">
                            @csrf

                            <!-- Họ và tên -->
                            <div class="mb-3">
                                <label for="full_name" class="form-label small fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" id="full_name" name="full_name"
                                       class="form-control @error('full_name') is-invalid @enderror"
                                       value="{{ old('full_name') }}" placeholder="Nguyễn Văn A" required autofocus>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="name@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mật khẩu -->
                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Tối thiểu 6 ký tự" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Xác nhận mật khẩu -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label small fw-semibold">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-control"
                                       placeholder="Nhập lại mật khẩu" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-dark fw-semibold">Đăng ký</button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <p class="text-center small text-secondary mb-0">
                            Đã có tài khoản?
                            <a href="{{ url('/login') }}" class="text-dark fw-semibold text-decoration-underline">Đăng nhập</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>