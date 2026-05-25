<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBlogTest extends TestCase
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

    public function test_admin_can_view_blog_categories_list(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/blog-categories');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_blog_category(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post('/dr-admin/blog-categories', [
                'title' => 'New Category',
                'status' => true,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('blog_categories', ['title' => 'New Category']);
    }

    public function test_admin_can_view_blogs_list(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/blogs');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_blog(): void
    {
        $category = BlogCategory::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/dr-admin/blogs', [
                'title' => 'New Blog Post',
                'category_id' => $category->id,
                'short_description' => 'A new blog post',
                'full_description' => '<p>Content here</p>',
                'status' => true,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('blogs', ['title' => 'New Blog Post']);
    }

    public function test_admin_can_edit_blog(): void
    {
        $category = BlogCategory::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        $blog = Blog::create([
            'title' => 'Edit Blog',
            'slug' => 'edit-blog',
            'category_id' => $category->id,
            'status' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/blogs/' . $blog->id . '/edit');

        $response->assertStatus(200);
        $response->assertSee('Edit Blog');
    }

    public function test_admin_can_update_blog(): void
    {
        $category = BlogCategory::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        $blog = Blog::create([
            'title' => 'Old Blog',
            'slug' => 'old-blog',
            'category_id' => $category->id,
            'status' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->put('/dr-admin/blogs/' . $blog->id, [
                'title' => 'Updated Blog',
                'category_id' => $category->id,
                'status' => true,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('blogs', ['title' => 'Updated Blog']);
    }

    public function test_admin_can_delete_blog(): void
    {
        $category = BlogCategory::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        $blog = Blog::create([
            'title' => 'Delete Blog',
            'slug' => 'delete-blog',
            'category_id' => $category->id,
            'status' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->delete('/dr-admin/blogs/' . $blog->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
    }
}
