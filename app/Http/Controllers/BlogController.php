<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->active()->latest()->paginate(9);
        $categories = BlogCategory::active()->withCount('blogs')->orderBy('title')->get();

        return view('blogs.index', compact('blogs', 'categories'));
    }

    public function show(Blog $blog)
    {
        if (!$blog->status) {
            abort(404);
        }

        $blog->load('category');
        $relatedBlogs = Blog::active()
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        return view('blogs.show', compact('blog', 'relatedBlogs'));
    }

    public function category(BlogCategory $category)
    {
        if (!$category->status) {
            abort(404);
        }

        $blogs = $category->blogs()->active()->latest()->paginate(9);
        $categories = BlogCategory::active()->withCount('blogs')->orderBy('title')->get();

        return view('blogs.index', compact('blogs', 'categories', 'category'));
    }
}
