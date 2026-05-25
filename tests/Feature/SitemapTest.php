<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_index_loads(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('sitemapindex', false);
        $response->assertSee('sitemap-pages.xml', false);
        $response->assertSee('sitemap-products.xml', false);
        $response->assertSee('sitemap-blogs.xml', false);
    }

    public function test_sitemap_pages_loads(): void
    {
        $response = $this->get('/sitemap-pages.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('<urlset', false);
    }

    public function test_sitemap_products_loads(): void
    {
        $category = Category::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        Product::create([
            'title' => 'Sitemap Product',
            'slug' => 'sitemap-product',
            'sku' => 'SMP-001',
            'category_id' => $category->id,
            'selling_price' => 500,
            'status' => true,
        ]);

        $response = $this->get('/sitemap-products.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('sitemap-product', false);
    }

    public function test_sitemap_blogs_loads(): void
    {
        $blogCat = BlogCategory::create(['title' => 'Test Cat', 'slug' => 'test-cat', 'status' => true]);
        Blog::create([
            'title' => 'Sitemap Blog',
            'slug' => 'sitemap-blog',
            'category_id' => $blogCat->id,
            'status' => true,
        ]);

        $response = $this->get('/sitemap-blogs.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('sitemap-blog', false);
    }

    public function test_robots_txt_exists(): void
    {
        $this->assertFileExists(public_path('robots.txt'));
    }
}
