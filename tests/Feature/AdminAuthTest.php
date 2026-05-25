<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_loads(): void
    {
        $response = $this->get('/dr-admin/login');
        $response->assertStatus(200);
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'password123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $response = $this->post('/dr-admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_admin_cannot_login_with_invalid_credentials(): void
    {
        Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'password123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $response = $this->post('/dr-admin/login', [
            'email' => 'admin@test.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest('admin');
    }

    public function test_admin_dashboard_requires_auth(): void
    {
        $response = $this->get('/dr-admin');
        $response->assertRedirect('/dr-admin/login');
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'password123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/dr-admin');
        $response->assertStatus(200);
    }

    public function test_admin_can_logout(): void
    {
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'password123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->post('/dr-admin/logout');
        $response->assertRedirect();
        $this->assertGuest('admin');
    }
}
