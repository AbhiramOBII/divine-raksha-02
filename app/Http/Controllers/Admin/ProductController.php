<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->status !== null && $request->status !== '', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::active()->orderBy('title')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('title')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'full_description' => ['nullable', 'string'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku'],
            'featured' => ['nullable', 'boolean'],
            'new_product' => ['nullable', 'boolean'],
            'bestseller' => ['nullable', 'boolean'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'featured_image_path' => ['nullable', 'string', 'max:500'],
            'gallery_image_paths' => ['nullable', 'array'],
            'gallery_image_paths.*' => ['nullable', 'string', 'max:500'],
            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['string'],
            'shop_purpose' => ['nullable', 'array'],
            'shop_purpose.*' => ['string'],
            'shop_by_raashi' => ['nullable', 'array'],
            'shop_by_raashi.*' => ['string'],
            'shop_by_numerology' => ['nullable', 'array'],
            'shop_by_numerology.*' => ['string'],
            'size' => ['nullable', 'array'],
            'size.*' => ['string'],
            'material' => ['nullable', 'string', 'max:255'],
            'weight' => ['nullable', 'string', 'max:255'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['featured'] = $request->boolean('featured');
        $validated['new_product'] = $request->boolean('new_product');
        $validated['bestseller'] = $request->boolean('bestseller');

        // Normalize empty arrays to null
        $jsonFields = ['attributes', 'shop_purpose', 'shop_by_raashi', 'shop_by_numerology', 'size'];
        foreach ($jsonFields as $field) {
            $validated[$field] = !empty($validated[$field]) ? $validated[$field] : null;
        }

        // Handle featured image from media library
        if ($request->filled('featured_image_path')) {
            $validated['featured_image'] = $request->input('featured_image_path');
        }
        unset($validated['featured_image_path']);

        // Handle gallery images from media library
        if ($request->filled('gallery_image_paths')) {
            $validated['gallery_images'] = $request->input('gallery_image_paths');
        }
        unset($validated['gallery_image_paths']);

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->orderBy('title')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'short_description' => ['nullable', 'string', 'max:255'],
            'full_description' => ['nullable', 'string'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku,' . $product->id],
            'featured' => ['nullable', 'boolean'],
            'new_product' => ['nullable', 'boolean'],
            'bestseller' => ['nullable', 'boolean'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'featured_image_path' => ['nullable', 'string', 'max:500'],
            'gallery_image_paths' => ['nullable', 'array'],
            'gallery_image_paths.*' => ['nullable', 'string', 'max:500'],
            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['string'],
            'shop_purpose' => ['nullable', 'array'],
            'shop_purpose.*' => ['string'],
            'shop_by_raashi' => ['nullable', 'array'],
            'shop_by_raashi.*' => ['string'],
            'shop_by_numerology' => ['nullable', 'array'],
            'shop_by_numerology.*' => ['string'],
            'size' => ['nullable', 'array'],
            'size.*' => ['string'],
            'material' => ['nullable', 'string', 'max:255'],
            'weight' => ['nullable', 'string', 'max:255'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['featured'] = $request->boolean('featured');
        $validated['new_product'] = $request->boolean('new_product');
        $validated['bestseller'] = $request->boolean('bestseller');

        // Normalize empty arrays to null
        $jsonFields = ['attributes', 'shop_purpose', 'shop_by_raashi', 'shop_by_numerology', 'size'];
        foreach ($jsonFields as $field) {
            $validated[$field] = !empty($validated[$field]) ? $validated[$field] : null;
        }

        // Handle featured image from media library
        if ($request->filled('featured_image_path')) {
            $validated['featured_image'] = $request->input('featured_image_path');
        }
        unset($validated['featured_image_path']);

        // Handle gallery images from media library
        if ($request->filled('gallery_image_paths')) {
            $validated['gallery_images'] = $request->input('gallery_image_paths');
        }
        unset($validated['gallery_image_paths']);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }
        if ($product->gallery_images) {
            foreach ($product->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

}
