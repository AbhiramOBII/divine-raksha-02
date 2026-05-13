<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'full_description',
        'thumbnail',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
