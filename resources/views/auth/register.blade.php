@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - Sách Sinh Viên')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-6 col-lg-5">
        <div class="border rounded-2 p-4 p-md-5 bg-white">
            <h1 class="fw-bold fs-3 mb-1">Tạo tài khoản mới</h1>
            <p class="text-secondary small mb-4">Điền thông tin bên dưới để mua giáo trình và sách tham khảo.</p>

            @if ($errors->any())
                <div class="alert alert-danger small py-2">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST">
                @csrf

                <!-- Họ và tên -->
                <div class="mb-3">
                    <label for="full_name" class="form-label fw-medium small">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text"
                            id="full_name"
                            name="full_name"
                            value="{{ old('full_name') }}"
                            class="form-control @error('full_name') is-invalid @enderror"
                            placeholder="Nguyễn Văn A"
                            required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                </div>
                

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-medium small">Email <span class="text-danger">*</span></label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           autocomplete="email"
                           required
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="sinhvien@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mật khẩu -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-medium small">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password"
                           id="password"
                           name="password"
                           autocomplete="new-password"
                           required
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Tối thiểu 6 ký tự">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nhập lại mật khẩu -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-medium small">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           autocomplete="new-password"
                           required
                           class="form-control"
                           placeholder="Nhập lại mật khẩu">
                </div>

                <button type="submit" class="btn btn-wireframe w-100 py-2 fw-medium">
                    Đăng ký tài khoản
                </button>
            </form>

            <div class="text-center small text-secondary mt-4 pt-3 border-top">
                Đã có tài khoản?
                <a href="{{ url('/login') }}" class="text-dark fw-semibold text-decoration-underline">Đăng nhập</a>
            </div>
        </div>
    </div>
</div>
@endsection