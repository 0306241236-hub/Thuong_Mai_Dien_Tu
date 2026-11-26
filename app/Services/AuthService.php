<?php

namespace App\Services;

 backend
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
=======
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
 develop

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

 backend
        $userData = [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        if (Schema::hasColumn('users', 'role')) {
            $userData['role'] = $data['role'] ?? 'customer';
        }

        return User::create($userData);

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'customer';
        $data['status'] = 'active';

        return $this->userRepository->create($data);
 develop
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
     * Đăng xuất (phòng trường hợp AuthController gọi qua AuthService)
     */
    public function logout(): void
    {
        Auth::logout();
    }

    public function logout(): void
    {
        Auth::logout();
    }
}