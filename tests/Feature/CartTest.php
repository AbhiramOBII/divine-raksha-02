<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(): Product
    {
        $category = Category::create([
            'title' => 'Test Cat',
            'slug' => 'test-cat',
            'status' => true,
        ]);

        return Product::create([
            'title' => 'Test Product',
            'slug' => 'test-product',
            'sku' => 'CRT-001',
            'category_id' => $category->id,
            'selling_price' => 999,
            'status' => true,
        ]);
    }

    public function test_cart_page_loads(): void
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    public function test_add_to_cart(): void
    {
        $product = $this->createProduct();

        $response = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_update_cart_quantity(): void
    {
        $product = $this->createProduct();

        // Add to cart first
        $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // Update quantity
        $response = $this->postJson('/cart/update', [
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_remove_from_cart(): void
    {
        $product = $this->createProduct();

        // Add to cart first
        $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // Remove
        $response = $this->postJson('/cart/remove', [
            'product_id' => $product->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_cart_count_endpoint(): void
    {
        $response = $this->getJson('/cart/count');
        $response->assertStatus(200);
        $response->assertJson(['count' => 0]);
    }
}
