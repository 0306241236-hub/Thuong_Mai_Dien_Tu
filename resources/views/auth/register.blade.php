@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - Cửa hàng sách')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <div class="card border rounded-3 shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h1 class="h4 fw-bold mb-1">Tạo tài khoản mới</h1>
                        <p class="text-secondary small mb-0">Điền thông tin bên dưới để mua sách nhanh chóng</p>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger small py-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/register') }}">
                        @csrf

                        <!-- Họ tên -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label small fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" id="full_name" name="full_name"
                                   class="form-control @error('full_name') is-invalid @enderror"
                                   value="{{ old('full_name') }}" placeholder="Nguyễn Văn A" required autofocus>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email & SĐT cùng hàng trên màn hình rộng -->
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-6">
                                <label for="email" class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="name@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="phone" class="form-label small fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}" placeholder="0901234567" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Địa chỉ -->
                        <div class="mb-3">
                            <label for="address" class="form-label small fw-semibold">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                            <input type="text" id="address" name="address"
                                   class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address') }}" placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mật khẩu & Xác nhận mật khẩu -->
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-6">
                                <label for="password" class="form-label small fw-semibold">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Tối thiểu 6 ký tự" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="password_confirmation" class="form-label small fw-semibold">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-control"
                                       placeholder="Nhập lại mật khẩu" required>
                            </div>
                        </div>

                        <!-- Nút đăng ký -->
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
</div>
@endsection