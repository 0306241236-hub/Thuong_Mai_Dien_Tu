<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Ghi đè APP_URL subfolder của XAMPP khi chạy PHPUnit để tránh lỗi 404
        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    private function createCustomerUser(): User
    {
        $data = [
            'email'    => 'customer_test@example.com',
            'password' => Hash::make('Password123!'),
        ];

        if (Schema::hasColumn('users', 'name')) {
            $data['name'] = 'Customer Test';
        }
        if (Schema::hasColumn('users', 'full_name')) {
            $data['full_name'] = 'Customer Test';
        }
        if (Schema::hasColumn('users', 'username')) {
            $data['username'] = 'customertest';
        }
        if (Schema::hasColumn('users', 'role')) {
            $data['role'] = 'customer';
        }
        if (Schema::hasColumn('users', 'created_at')) {
            $data['created_at'] = now();
            $data['updated_at'] = now();
        }

        $userId = DB::table('users')->insertGetId($data);

        return User::findOrFail($userId);
    }

    /**
     * Khách chưa đăng nhập vào trang admin phải bị chuyển hướng về /login
     */
    public function test_guest_cannot_access_admin_page(): void
    {
        $response = $this->get('/admin/products');

        $response->assertRedirect(route('login'));
    }

    /**
     * Tài khoản customer thường vào trang admin phải bị chặn (403 hoặc redirect)
     */
    public function test_customer_cannot_access_admin_page(): void
    {
        $customer = $this->createCustomerUser();

        $response = $this->actingAs($customer)->get('/admin/products');

        $this->assertTrue(
            in_array($response->status(), [302, 403]),
            "Kỳ vọng mã 403 hoặc 302 khi customer vào /admin/products, thực tế nhận: {$response->status()}"
        );
    }
}