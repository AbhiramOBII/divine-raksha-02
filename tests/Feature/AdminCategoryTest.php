<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => 'password123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_view_categories_list(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/categories');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_category(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post('/dr-admin/categories', [
                'title' => 'New Category',
                'slug' => 'new-category',
                'status' => true,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', ['title' => 'New Category']);
    }

    public function test_admin_can_edit_category(): void
    {
        $category = Category::create(['title' => 'Edit Cat', 'slug' => 'edit-cat', 'status' => true]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/categories/' . $category->id . '/edit');

        $response->assertStatus(200);
        $response->assertSee('Edit Cat');
    }

    public function test_admin_can_update_category(): void
    {
        $category = Category::create(['title' => 'Old Name', 'slug' => 'old-name', 'status' => true]);

        $response = $this->actingAs($this->admin, 'admin')
            ->put('/dr-admin/categories/' . $category->id, [
                'title' => 'Updated Name',
                'slug' => 'updated-name',
                'status' => true,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', ['title' => 'Updated Name']);
    }

    public function test_admin_can_delete_category(): void
    {
        $category = Category::create(['title' => 'Delete Me', 'slug' => 'delete-me', 'status' => true]);

        $response = $this->actingAs($this->admin, 'admin')
            ->delete('/dr-admin/categories/' . $category->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
