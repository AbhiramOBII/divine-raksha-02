<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    private function createBlog(array $overrides = []): Blog
    {
        $category = BlogCategory::firstOrCreate(
            ['slug' => 'spirituality'],
            ['title' => 'Spirituality', 'status' => true]
        );

        return Blog::create(array_merge([
            'title' => 'Test Blog',
            'slug' => 'test-blog',
            'category_id' => $category->id,
            'short_description' => 'Short description',
            'full_description' => '<p>Full description</p>',
            'status' => true,
        ], $overrides));
    }

    public function test_blog_index_page_loads(): void
    {
        $response = $this->get('/blogs');
        $response->assertStatus(200);
    }

    public function test_blog_index_displays_active_blogs(): void
    {
        $this->createBlog(['title' => 'Published Blog', 'slug' => 'published-blog', 'status' => true]);
        $this->createBlog(['title' => 'Draft Blog', 'slug' => 'draft-blog', 'status' => false]);

        $response = $this->get('/blogs');
        $response->assertStatus(200);
        $response->assertSee('Published Blog');
        $response->assertDontSee('Draft Blog');
    }

    public function test_blog_show_page_loads(): void
    {
        $blog = $this->createBlog();

        $response = $this->get('/blogs/' . $blog->slug);
        $response->assertStatus(200);
        $response->assertSee('Test Blog');
    }

    public function test_blog_show_has_structured_data(): void
    {
        $blog = $this->createBlog();

        $response = $this->get('/blogs/' . $blog->slug);
        $response->assertStatus(200);
        $response->assertSee('application/ld+json', false);
    }

    public function test_blog_category_filter_works(): void
    {
        $cat1 = BlogCategory::create(['title' => 'Category A', 'slug' => 'category-a', 'status' => true]);
        $cat2 = BlogCategory::create(['title' => 'Category B', 'slug' => 'category-b', 'status' => true]);

        Blog::create(['title' => 'Blog A', 'slug' => 'blog-a', 'category_id' => $cat1->id, 'status' => true]);
        Blog::create(['title' => 'Blog B', 'slug' => 'blog-b', 'category_id' => $cat2->id, 'status' => true]);

        $response = $this->get('/blogs/category/' . $cat1->slug);
        $response->assertStatus(200);
        $response->assertSee('Blog A');
        $response->assertDontSee('Blog B');
    }

    public function test_blog_seo_meta_tags_present(): void
    {
        $response = $this->get('/blogs');
        $response->assertStatus(200);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('<link rel="canonical"', false);
    }
}
