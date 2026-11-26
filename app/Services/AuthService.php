<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AuthService
{
    /**
     * Đăng ký tài khoản mới, từ chối nếu email đã tồn tại.
     */
    public function register(array $data): User
    {
        if (User::where('email', $data['email'])->exists()) {
            throw new Exception('Email đã được sử dụng.');
        }

        $userData = [
            'name'     => $data['name'] ?? $data['full_name'] ?? 'Người dùng',
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        if (Schema::hasColumn('users', 'full_name') && isset($data['full_name'])) {
            $userData['full_name'] = $data['full_name'];
        }
        if (Schema::hasColumn('users', 'phone') && isset($data['phone'])) {
            $userData['phone'] = $data['phone'];
        }
        if (Schema::hasColumn('users', 'address') && isset($data['address'])) {
            $userData['address'] = $data['address'];
        }
        if (Schema::hasColumn('users', 'role')) {
            $userData['role'] = $data['role'] ?? 'customer';
        }
        if (Schema::hasColumn('users', 'status')) {
            $userData['status'] = 'active';
        }

        return User::create($userData);
    }

    /**
     * Đăng nhập: hỗ trợ cả truyền mảng $credentials từ AuthController
     * lẫn truyền ($email, $password) từ Unit Test.
     */
    public function login(array|string $credentials, string|bool $passwordOrRemember = false): User
    {
        if (is_array($credentials)) {
            $email    = $credentials['email'] ?? '';
            $password = $credentials['password'] ?? '';
            $remember = (bool) $passwordOrRemember;
        } else {
            $email    = $credentials;
            $password = (string) $passwordOrRemember;
            $remember = false;
        }

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new Exception('Email hoặc mật khẩu không chính xác.');
        }

        // Kiểm tra tài khoản bị khóa
        $isLocked = false;
        if (Schema::hasColumn('users', 'status') && in_array($user->status, ['locked', 'banned', 'inactive', 0, '0'], true)) {
            $isLocked = true;
        }
        if (Schema::hasColumn('users', 'is_locked') && (bool) $user->is_locked === true) {
            $isLocked = true;
        }
        if (Schema::hasColumn('users', 'is_active') && (bool) $user->is_active === false) {
            $isLocked = true;
        }

        if ($isLocked) {
            throw new Exception('Tài khoản của bạn đã bị khóa.');
        }

        Auth::login($user, $remember);

        return $user;
    }

    /**
     * Đăng xuất
     */
    public function logout(): void
    {
        Auth::logout();
    }
}