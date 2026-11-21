<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'customer';
        $data['status'] = 'active';
        return $this->userRepository->create($data);
    }

    public function login(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);

        // Gộp chung thông báo lỗi sai email hoặc sai mật khẩu
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email hoặc mật khẩu không chính xác.'],
            ]);
        }

        // Chặn tài khoản bị khóa
        if ($user->status === 'locked') {
            throw ValidationException::withMessages([
                'email' => ['Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.'],
            ]);
        }

        Auth::login($user);
        request()->session()->regenerate();

        return [
            'user'     => $user,
            'redirect' => $user->role === 'admin' ? '/admin' : '/',
        ];
    }
}