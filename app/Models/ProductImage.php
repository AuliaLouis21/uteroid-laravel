<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'filename', 'is_thumbnail'];

    protected $appends = ['path'];

    protected $casts = [
        'is_thumbnail' => 'boolean',
    ];

    public function getPathAttribute(): string
    {
        return $this->filename;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->filename);
    }
}
