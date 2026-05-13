<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->boolean('featured')->default(false);
            $table->boolean('new_product')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('attributes')->nullable();
            $table->json('shop_purpose')->nullable();
            $table->json('shop_by_raashi')->nullable();
            $table->json('shop_by_numerology')->nullable();
            $table->json('size')->nullable();
            $table->string('material')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('brand_name')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
