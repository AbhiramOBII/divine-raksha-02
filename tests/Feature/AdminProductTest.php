<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductTest extends TestCase
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

    public function test_admin_can_view_products_list(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/products');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_create_product_form(): void
    {
        Category::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/products/create');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_product(): void
    {
        $category = Category::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/dr-admin/products', [
                'title' => 'New Product',
                'sku' => 'NEW-001',
                'slug' => 'new-product',
                'category_id' => $category->id,
                'selling_price' => 1499,
                'cost_price' => 800,
                'status' => 1,
            ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['title' => 'New Product', 'sku' => 'NEW-001']);
    }

    public function test_admin_can_edit_product(): void
    {
        $category = Category::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        $product = Product::create([
            'title' => 'Edit Me',
            'slug' => 'edit-me',
            'sku' => 'EDT-001',
            'category_id' => $category->id,
            'selling_price' => 500,
            'status' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/products/' . $product->id . '/edit');

        $response->assertStatus(200);
        $response->assertSee('Edit Me');
    }

    public function test_admin_can_update_product(): void
    {
        $category = Category::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        $product = Product::create([
            'title' => 'Old Title',
            'slug' => 'old-title',
            'sku' => 'UPD-001',
            'category_id' => $category->id,
            'selling_price' => 500,
            'cost_price' => 300,
            'status' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->put('/dr-admin/products/' . $product->id, [
                'title' => 'Updated Title',
                'slug' => 'old-title',
                'sku' => 'UPD-001',
                'category_id' => $category->id,
                'selling_price' => 699,
                'cost_price' => 400,
                'status' => 1,
            ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['title' => 'Updated Title']);
    }

    public function test_admin_can_delete_product(): void
    {
        $category = Category::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        $product = Product::create([
            'title' => 'Delete Me',
            'slug' => 'delete-me',
            'sku' => 'DEL-001',
            'category_id' => $category->id,
            'selling_price' => 500,
            'status' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->delete('/dr-admin/products/' . $product->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
