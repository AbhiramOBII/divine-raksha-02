<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $content .= '<sitemap><loc>' . url('/sitemap-pages.xml') . '</loc></sitemap>';
        $content .= '<sitemap><loc>' . url('/sitemap-products.xml') . '</loc></sitemap>';
        $content .= '<sitemap><loc>' . url('/sitemap-blogs.xml') . '</loc></sitemap>';
        $content .= '</sitemapindex>';

        return response($content, 200)->header('Content-Type', 'application/xml');
    }

    public function pages()
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('products.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => route('shop.bestsellers'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('blogs.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('about'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => route('contact'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => route('faq'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('care-instructions'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('terms'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('privacy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('disclaimer'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('return-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        // Add product categories
        $categories = Category::where('status', true)->get();
        foreach ($categories as $category) {
            $urls[] = [
                'loc' => route('products.index', ['category' => $category->slug]),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        }

        // Add blog categories
        $blogCategories = BlogCategory::active()->get();
        foreach ($blogCategories as $cat) {
            $urls[] = [
                'loc' => route('blogs.category', $cat),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        }

        return $this->buildUrlset($urls);
    }

    public function products()
    {
        $urls = [];
        $products = Product::where('status', true)->latest()->get();

        foreach ($products as $product) {
            $urls[] = [
                'loc' => route('products.show', $product),
                'lastmod' => $product->updated_at->toW3cString(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        }

        return $this->buildUrlset($urls);
    }

    public function blogs()
    {
        $urls = [];
        $blogs = Blog::active()->latest()->get();

        foreach ($blogs as $blog) {
            $urls[] = [
                'loc' => route('blogs.show', $blog),
                'lastmod' => $blog->updated_at->toW3cString(),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ];
        }

        return $this->buildUrlset($urls);
    }

    private function buildUrlset(array $urls)
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $content .= '<url>';
            $content .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            if (isset($url['lastmod'])) {
                $content .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            }
            $content .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $content .= '<priority>' . $url['priority'] . '</priority>';
            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
