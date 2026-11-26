@extends('layouts.app')

@section('title', 'Đăng nhập - Sách Sinh Viên')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-6 col-lg-5">
        <div class="border rounded-2 p-4 p-md-5 bg-white">
            <h1 class="fw-bold fs-3 mb-1">Đăng nhập</h1>
            <p class="text-secondary small mb-4">Đăng nhập để quản lý giỏ hàng và theo dõi đơn đặt sách.</p>

            {{-- Thông báo lỗi chung hoặc đăng ký thành công --}}
            @if (session('success'))
                <div class="alert alert-success small py-2">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger small py-2">{{ session('error') }}</div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf

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
                <div class="mb-4">
                    <label for="password" class="form-label fw-medium small">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password"
                           id="password"
                           name="password"
                           autocomplete="current-password"
                           required
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Nhập mật khẩu">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-wireframe w-100 py-2 fw-medium">
                    Đăng nhập
                </button>
            </form>

            <div class="text-center small text-secondary mt-4 pt-3 border-top">
                Chưa có tài khoản?
                <a href="{{ url('/register') }}" class="text-dark fw-semibold text-decoration-underline">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</div>
@endsection