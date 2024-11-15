<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasUlids, HasSlug;

    protected $guarded = ['id'];
    // protected $fillabel = ['name', 'description', 'price', 'category_id'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(fn($query) =>
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%'));
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->where('category_id', $category);
        });

        $query->when($filters['price'] ?? false, function ($query, $price) {
            $query->where('price', '<=', $price);
        });

        $query->when($filters['is_active'] ?? false, function ($query, $is_active) {
            $is_active = $is_active === 'active' ? 1 : 0;
            $query->where('is_active', $is_active);
        });
    }

    public function scopeSort($query, $value)
    {
        $value = explode('|', $value);
        $query->orderBy($value[0], $value[1]);
    }
}
