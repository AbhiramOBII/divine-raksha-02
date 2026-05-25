<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private int $skuCounter = 0;

    private function createProduct(array $overrides = []): Product
    {
        $this->skuCounter++;

        $category = Category::firstOrCreate(
            ['slug' => 'rudraksha'],
            ['title' => 'Rudraksha', 'status' => true]
        );

        return Product::create(array_merge([
            'title' => 'Test Product',
            'slug' => 'test-product-' . $this->skuCounter,
            'sku' => 'TST-' . str_pad($this->skuCounter, 3, '0', STR_PAD_LEFT),
            'category_id' => $category->id,
            'selling_price' => 999,
            'status' => true,
        ], $overrides));
    }

    public function test_products_index_page_loads(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
    }

    public function test_products_index_displays_active_products(): void
    {
        $this->createProduct(['title' => 'Active Product', 'slug' => 'active-product', 'status' => true]);
        $this->createProduct(['title' => 'Inactive Product', 'slug' => 'inactive-product', 'status' => false]);

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('Active Product');
        $response->assertDontSee('Inactive Product');
    }

    public function test_product_show_page_loads(): void
    {
        $product = $this->createProduct();

        $response = $this->get('/products/' . $product->slug);
        $response->assertStatus(200);
        $response->assertSee('Test Product');
    }

    public function test_product_show_has_structured_data(): void
    {
        $product = $this->createProduct();

        $response = $this->get('/products/' . $product->slug);
        $response->assertStatus(200);
        $response->assertSee('application/ld+json', false);
    }

    public function test_products_filter_by_category(): void
    {
        $cat1 = Category::create(['title' => 'Cat A', 'slug' => 'cat-a', 'status' => true]);
        $cat2 = Category::create(['title' => 'Cat B', 'slug' => 'cat-b', 'status' => true]);

        Product::create(['title' => 'Product A', 'slug' => 'product-a', 'sku' => 'PA-001', 'category_id' => $cat1->id, 'selling_price' => 100, 'status' => true]);
        Product::create(['title' => 'Product B', 'slug' => 'product-b', 'sku' => 'PB-001', 'category_id' => $cat2->id, 'selling_price' => 200, 'status' => true]);

        $response = $this->get('/products?category=' . $cat1->id);
        $response->assertStatus(200);
        $response->assertSee('Product A');
        $response->assertDontSee('Product B');
    }

    public function test_shop_by_raashi_page_loads(): void
    {
        $response = $this->get('/shop-by-raashi');
        $response->assertStatus(200);
    }

    public function test_shop_by_raashi_with_specific_raashi(): void
    {
        $category = Category::create(['title' => 'Gems', 'slug' => 'gems', 'status' => true]);
        Product::create([
            'title' => 'Makara Product',
            'slug' => 'makara-product',
            'sku' => 'MKR-001',
            'category_id' => $category->id,
            'selling_price' => 500,
            'shop_by_raashi' => ['Makara'],
            'status' => true,
        ]);

        $response = $this->get('/shop-by-raashi/makara');
        $response->assertStatus(200);
        $response->assertSee('Makara Product');
    }

    public function test_shop_by_purpose_page_loads(): void
    {
        $response = $this->get('/shop-by-purpose');
        $response->assertStatus(200);
    }

    public function test_shop_by_numerology_page_loads(): void
    {
        $response = $this->get('/shop-by-numerology');
        $response->assertStatus(200);
    }

    public function test_bestsellers_page_loads(): void
    {
        $response = $this->get('/bestsellers');
        $response->assertStatus(200);
    }
}
