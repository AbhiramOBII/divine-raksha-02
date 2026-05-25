<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SEOTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_has_organization_schema(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('Organization', false);
    }

    public function test_product_page_has_product_schema(): void
    {
        $category = Category::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        $product = Product::create([
            'title' => 'SEO Product',
            'slug' => 'seo-product',
            'sku' => 'SEO-001',
            'category_id' => $category->id,
            'selling_price' => 1500,
            'status' => true,
        ]);

        $response = $this->get('/products/seo-product');
        $response->assertStatus(200);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('"Product"', false);
    }

    public function test_blog_page_has_blog_posting_schema(): void
    {
        $category = BlogCategory::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        $blog = Blog::create([
            'title' => 'SEO Blog',
            'slug' => 'seo-blog',
            'category_id' => $category->id,
            'full_description' => '<p>Content</p>',
            'status' => true,
        ]);

        $response = $this->get('/blogs/seo-blog');
        $response->assertStatus(200);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('BlogPosting', false);
    }

    public function test_product_page_has_correct_og_type(): void
    {
        $category = Category::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        Product::create([
            'title' => 'OG Product',
            'slug' => 'og-product',
            'sku' => 'OG-001',
            'category_id' => $category->id,
            'selling_price' => 999,
            'status' => true,
        ]);

        $response = $this->get('/products/og-product');
        $response->assertStatus(200);
        $response->assertSee('og:type" content="product"', false);
    }

    public function test_blog_page_has_correct_og_type(): void
    {
        $category = BlogCategory::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        Blog::create([
            'title' => 'OG Blog',
            'slug' => 'og-blog',
            'category_id' => $category->id,
            'full_description' => '<p>Content</p>',
            'status' => true,
        ]);

        $response = $this->get('/blogs/og-blog');
        $response->assertStatus(200);
        $response->assertSee('og:type" content="article"', false);
    }

    public function test_pages_have_canonical_urls(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('rel="canonical"', false);

        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('rel="canonical"', false);

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('rel="canonical"', false);
    }

    public function test_pages_have_twitter_card_meta(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('twitter:card', false);
        $response->assertSee('twitter:title', false);
        $response->assertSee('twitter:description', false);
    }
}
