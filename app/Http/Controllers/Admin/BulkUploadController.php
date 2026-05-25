<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BulkUploadController extends Controller
{
    public function index()
    {
        $categories = Category::active()->orderBy('title')->get();
        return view('admin.bulk-upload.index', compact('categories'));
    }

    public function template()
    {
        $headers = [
            'title',
            'category_name',
            'sku',
            'short_description',
            'full_description',
            'cost_price',
            'selling_price',
            'stock',
            'material',
            'weight',
            'dimensions',
            'brand_name',
            'featured',
            'new_product',
            'bestseller',
            'status',
            'attributes',
            'shop_purpose',
            'shop_by_raashi',
            'shop_by_numerology',
            'size',
            'meta_title',
            'meta_description',
        ];

        $sampleRow = [
            'Rudraksha 5 Mukhi Mala',
            'Rudraksha',
            'RDK-001',
            'Authentic 5 Mukhi Rudraksha Mala for peace and prosperity',
            'Full description with HTML if needed',
            '500',
            '999',
            '50',
            'Natural Rudraksha',
            '25g',
            '10x10x2 cm',
            'Divine Raksha',
            '1',
            '0',
            '1',
            '1',
            'Natural|Blessed',
            'Wealth|Peace|Protection',
            'Mesha|Simha|Dhanu',
            '1|5|9',
            'Small|Medium|Large',
            'Rudraksha 5 Mukhi Mala - Buy Online',
            'Buy authentic 5 Mukhi Rudraksha Mala for peace and prosperity.',
        ];

        $csv = implode(',', $headers) . "\n";
        $csv .= implode(',', array_map(function ($val) {
            return '"' . str_replace('"', '""', $val) . '"';
        }, $sampleRow)) . "\n";

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="products_bulk_template.csv"');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $rows = array_map('str_getcsv', file($path));
        $headers = array_map('trim', array_shift($rows));

        if (empty($rows)) {
            return back()->with('error', 'The CSV file is empty.');
        }

        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        $categories = Category::all()->keyBy(function ($cat) {
            return strtolower($cat->title);
        });

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 because header is row 1

            if (count($row) < count($headers)) {
                $row = array_pad($row, count($headers), '');
            }

            $data = array_combine($headers, array_slice($row, 0, count($headers)));

            // Validate required fields
            if (empty($data['title']) || empty($data['selling_price'])) {
                $results['failed']++;
                $results['errors'][] = "Row {$rowNumber}: Title and selling_price are required.";
                continue;
            }

            // Find or skip category
            $categoryId = null;
            if (!empty($data['category_name'])) {
                $catKey = strtolower(trim($data['category_name']));
                if ($categories->has($catKey)) {
                    $categoryId = $categories->get($catKey)->id;
                } else {
                    // Create category if not exists
                    $newCat = Category::create([
                        'title' => trim($data['category_name']),
                        'slug' => Str::slug($data['category_name']),
                        'status' => true,
                    ]);
                    $categories->put($catKey, $newCat);
                    $categoryId = $newCat->id;
                }
            }

            try {
                $slug = Str::slug($data['title']);
                $originalSlug = $slug;
                $counter = 1;
                while (Product::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $product = Product::create([
                    'category_id' => $categoryId,
                    'title' => trim($data['title']),
                    'slug' => $slug,
                    'sku' => trim($data['sku'] ?? ''),
                    'short_description' => $data['short_description'] ?? null,
                    'full_description' => $data['full_description'] ?? null,
                    'cost_price' => is_numeric($data['cost_price'] ?? null) ? $data['cost_price'] : 0,
                    'selling_price' => (float) $data['selling_price'],
                    'material' => $data['material'] ?? null,
                    'weight' => $data['weight'] ?? null,
                    'dimensions' => $data['dimensions'] ?? null,
                    'brand_name' => $data['brand_name'] ?? null,
                    'featured' => (bool) ($data['featured'] ?? false),
                    'new_product' => (bool) ($data['new_product'] ?? false),
                    'bestseller' => (bool) ($data['bestseller'] ?? false),
                    'status' => (bool) ($data['status'] ?? true),
                    'attributes' => $this->parsePipeDelimited($data['attributes'] ?? ''),
                    'shop_purpose' => $this->parsePipeDelimited($data['shop_purpose'] ?? ''),
                    'shop_by_raashi' => $this->parsePipeDelimited($data['shop_by_raashi'] ?? ''),
                    'shop_by_numerology' => $this->parsePipeDelimited($data['shop_by_numerology'] ?? ''),
                    'size' => $this->parsePipeDelimited($data['size'] ?? ''),
                    'meta_title' => $data['meta_title'] ?? null,
                    'meta_description' => $data['meta_description'] ?? null,
                ]);

                // Create stock entry
                $stockQty = is_numeric($data['stock'] ?? null) ? (int) $data['stock'] : 0;
                if ($stockQty > 0) {
                    ProductStock::create([
                        'product_id' => $product->id,
                        'size' => null,
                        'quantity' => $stockQty,
                    ]);
                }

                $results['success']++;
            } catch (\Exception $e) {
                $results['failed']++;
                $results['errors'][] = "Row {$rowNumber}: " . $e->getMessage();
            }
        }

        return back()->with('results', $results);
    }

    private function parsePipeDelimited(?string $value): ?array
    {
        if (empty($value)) {
            return null;
        }

        $items = array_map('trim', explode('|', $value));
        $items = array_filter($items);

        return !empty($items) ? array_values($items) : null;
    }
}
