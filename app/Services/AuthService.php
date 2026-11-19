<?php
namespace App\Services;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        // Laravel sử dụng Bcrypt mặc định cho hàm Hash::make, đáp ứng yêu cầu không dùng MD5/SHA1
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data); // Hàm create này viết ở BaseRepository
    }
}