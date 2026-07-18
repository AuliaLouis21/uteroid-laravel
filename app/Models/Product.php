<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'size',
        'thickness',
        'min_order',
        'unit_price',
        'description',
        'product_category_id',
        'product_type_id',
        'is_promo',
        'published_at',
        'published_time',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'is_promo' => 'boolean',
        'min_order' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPriceAttribute()
    {
        return $this->unit_price;
    }
}
