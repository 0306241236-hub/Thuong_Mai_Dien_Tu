<?php

namespace Tests\Unit;

use App\Services\AuthService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    private function insertUser(string $email, array $extra = []): int
    {
        $data = array_merge([
            'email'    => $email,
            'password' => Hash::make('Password123!'),
        ], $extra);

        if (Schema::hasColumn('users', 'name') && !isset($data['name'])) {
            $data['name'] = 'Người Dùng Test';
        }
        if (Schema::hasColumn('users', 'full_name') && !isset($data['full_name'])) {
            $data['full_name'] = 'Người Dùng Test';
        }
        if (Schema::hasColumn('users', 'username') && !isset($data['username'])) {
            $data['username'] = 'user_' . uniqid();
        }
        if (Schema::hasColumn('users', 'role') && !isset($data['role'])) {
            $data['role'] = 'customer';
        }
        if (Schema::hasColumn('users', 'created_at')) {
            $data['created_at'] = now();
            $data['updated_at'] = now();
        }

        return DB::table('users')->insertGetId($data);
    }

    /**
     * Test 1: Đăng ký email trùng bị từ chối
     */
    public function test_register_rejects_duplicate_email(): void
    {
        $this->insertUser('trungemail@example.com');

        $this->expectException(Exception::class);

        try {
            $this->authService->register([
                'name'     => 'Người Dùng Mới',
                'email'    => 'trungemail@example.com',
                'password' => 'Password123!',
            ]);
        } finally {
            $this->assertEquals(1, DB::table('users')->where('email', 'trungemail@example.com')->count());
        }
    }

    /**
     * Test 2: Đăng nhập tài khoản bị khóa bị từ chối
     */
    public function test_login_rejects_locked_account(): void
    {
        $lockData = [];
        if (Schema::hasColumn('users', 'status')) {
            $lockData['status'] = 'locked';
        }
        if (Schema::hasColumn('users', 'is_locked')) {
            $lockData['is_locked'] = true;
        }
        if (Schema::hasColumn('users', 'is_active')) {
            $lockData['is_active'] = false;
        }

        if (empty($lockData)) {
            $this->markTestSkipped('Bảng users chưa có cột trạng thái khóa.');
        }

        $this->insertUser('lockeduser@example.com', $lockData);

        $this->expectException(Exception::class);

        try {
            $this->authService->login('lockeduser@example.com', 'Password123!');
        } finally {
            $this->assertFalse(Auth::check());
        }
    }
}