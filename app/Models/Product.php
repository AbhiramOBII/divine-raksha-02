<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'short_description',
        'full_description',
        'sku',
        'slug',
        'featured',
        'new_product',
        'bestseller',
        'cost_price',
        'selling_price',
        'featured_image',
        'gallery_images',
        'attributes',
        'shop_purpose',
        'shop_by_raashi',
        'shop_by_numerology',
        'size',
        'material',
        'weight',
        'dimensions',
        'meta_title',
        'meta_description',
        'brand_name',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'new_product' => 'boolean',
            'bestseller' => 'boolean',
            'cost_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'gallery_images' => 'array',
            'attributes' => 'array',
            'shop_purpose' => 'array',
            'shop_by_raashi' => 'array',
            'shop_by_numerology' => 'array',
            'size' => 'array',
            'status' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    public function getTotalStockAttribute(): int
    {
        return $this->stocks->sum('quantity');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('bestseller', true);
    }

    public function scopeNewProduct($query)
    {
        return $query->where('new_product', true);
    }

    public function getDiscountPercentageAttribute(): float
    {
        if ($this->cost_price > 0 && $this->cost_price > $this->selling_price) {
            return round((($this->cost_price - $this->selling_price) / $this->cost_price) * 100);
        }
        return 0;
    }
}
