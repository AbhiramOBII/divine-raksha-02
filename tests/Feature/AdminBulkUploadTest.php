<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminBulkUploadTest extends TestCase
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

    public function test_bulk_upload_page_loads(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/bulk-upload');

        $response->assertStatus(200);
    }

    public function test_bulk_upload_template_downloads(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get('/dr-admin/bulk-upload/template');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertSee('title,category_name,sku');
    }

    public function test_bulk_upload_creates_products(): void
    {
        $csv = "title,category_name,sku,short_description,full_description,cost_price,selling_price,stock,material,weight,dimensions,brand_name,featured,new_product,bestseller,status,attributes,shop_purpose,shop_by_raashi,shop_by_numerology,size,meta_title,meta_description\n";
        $csv .= '"Bulk Product 1","Rudraksha","BLK-001","Short desc","Full desc","500","999","25","Wood","20g","5x5 cm","Divine Raksha","1","0","1","1","Natural|Blessed","Wealth|Peace","Mesha|Simha","1|5","Small|Medium","Meta Title","Meta Desc"' . "\n";
        $csv .= '"Bulk Product 2","Gemstones","BLK-002","Short desc 2","Full desc 2","300","599","10","Stone","15g","3x3 cm","Divine Raksha","0","1","0","1","Handcrafted","Love","Karka","2","Large","Meta Title 2","Meta Desc 2"' . "\n";

        $file = UploadedFile::fake()->createWithContent('products.csv', $csv);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/dr-admin/bulk-upload', [
                'csv_file' => $file,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('results');

        $this->assertDatabaseHas('products', ['title' => 'Bulk Product 1', 'sku' => 'BLK-001']);
        $this->assertDatabaseHas('products', ['title' => 'Bulk Product 2', 'sku' => 'BLK-002']);
        $this->assertDatabaseHas('categories', ['title' => 'Rudraksha']);
        $this->assertDatabaseHas('categories', ['title' => 'Gemstones']);
    }

    public function test_bulk_upload_creates_stock_entries(): void
    {
        $csv = "title,category_name,sku,short_description,full_description,cost_price,selling_price,stock,material,weight,dimensions,brand_name,featured,new_product,bestseller,status,attributes,shop_purpose,shop_by_raashi,shop_by_numerology,size,meta_title,meta_description\n";
        $csv .= '"Stock Product","Test Cat","STK-001","","","100","299","50","","","","","0","0","0","1","","","","","","",""' . "\n";

        $file = UploadedFile::fake()->createWithContent('products.csv', $csv);

        $this->actingAs($this->admin, 'admin')
            ->post('/dr-admin/bulk-upload', ['csv_file' => $file]);

        $product = Product::where('title', 'Stock Product')->first();
        $this->assertNotNull($product);
        $this->assertDatabaseHas('product_stocks', [
            'product_id' => $product->id,
            'quantity' => 50,
        ]);
    }

    public function test_bulk_upload_handles_duplicate_slugs(): void
    {
        $category = Category::create(['title' => 'Test', 'slug' => 'test', 'status' => true]);
        Product::create(['title' => 'Same Name', 'slug' => 'same-name', 'sku' => 'EXIST-001', 'category_id' => $category->id, 'selling_price' => 100, 'status' => true]);

        $csv = "title,category_name,sku,short_description,full_description,cost_price,selling_price,stock,material,weight,dimensions,brand_name,featured,new_product,bestseller,status,attributes,shop_purpose,shop_by_raashi,shop_by_numerology,size,meta_title,meta_description\n";
        $csv .= '"Same Name","Test","DUP-001","","","100","299","0","","","","","0","0","0","1","","","","","","",""' . "\n";

        $file = UploadedFile::fake()->createWithContent('products.csv', $csv);

        $this->actingAs($this->admin, 'admin')
            ->post('/dr-admin/bulk-upload', ['csv_file' => $file]);

        $this->assertEquals(2, Product::where('title', 'Same Name')->count());
        $this->assertDatabaseHas('products', ['slug' => 'same-name-1']);
    }

    public function test_bulk_upload_validates_required_fields(): void
    {
        $csv = "title,category_name,sku,short_description,full_description,cost_price,selling_price,stock,material,weight,dimensions,brand_name,featured,new_product,bestseller,status,attributes,shop_purpose,shop_by_raashi,shop_by_numerology,size,meta_title,meta_description\n";
        $csv .= '"","","","","","","","","","","","","","","","","","","","","","",""' . "\n";

        $file = UploadedFile::fake()->createWithContent('products.csv', $csv);

        $response = $this->actingAs($this->admin, 'admin')
            ->post('/dr-admin/bulk-upload', ['csv_file' => $file]);

        $response->assertRedirect();
        $results = session('results');
        $this->assertEquals(0, $results['success']);
        $this->assertEquals(1, $results['failed']);
    }

    public function test_bulk_upload_requires_csv_file(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post('/dr-admin/bulk-upload', []);

        $response->assertSessionHasErrors('csv_file');
    }
}
