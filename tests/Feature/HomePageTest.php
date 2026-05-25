<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_home_page_displays_bestsellers(): void
    {
        $category = Category::create([
            'title' => 'Rudraksha',
            'slug' => 'rudraksha',
            'status' => true,
        ]);

        $product = Product::create([
            'title' => 'Test Bestseller',
            'slug' => 'test-bestseller',
            'sku' => 'BST-001',
            'category_id' => $category->id,
            'selling_price' => 999,
            'bestseller' => true,
            'status' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Test Bestseller');
    }

    public function test_home_page_displays_latest_blogs(): void
    {
        $blogCat = BlogCategory::create([
            'title' => 'Spirituality',
            'slug' => 'spirituality',
            'status' => true,
        ]);

        Blog::create([
            'title' => 'Test Blog Post',
            'slug' => 'test-blog-post',
            'category_id' => $blogCat->id,
            'short_description' => 'A test blog',
            'status' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Test Blog Post');
    }

    public function test_home_page_contains_seo_meta_tags(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('<link rel="canonical"', false);
        $response->assertSee('<meta property="og:type"', false);
        $response->assertSee('<meta name="twitter:card"', false);
    }
}
