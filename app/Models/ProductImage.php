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

    /** @var array<string, string> Static cache for WebP URLs to avoid file_exists() on every request */
    protected static array $webpUrlCache = [];

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
        return asset('storage/'.$this->filename);
    }

    /**
     * Get WebP version URL if it exists, otherwise return original.
     * Uses static cache to avoid file_exists() overhead on every request.
     */
    public function getWebpUrlAttribute(): string
    {
        $filename = $this->filename;

        // Return cached result if available
        if (isset(static::$webpUrlCache[$filename])) {
            return static::$webpUrlCache[$filename];
        }

        $lower = strtolower($filename);

        if (str_ends_with($lower, '.jpg') || str_ends_with($lower, '.jpeg') || str_ends_with($lower, '.png')) {
            $nameWithoutExt = substr($filename, 0, strrpos($filename, '.'));
            $webpPath = $nameWithoutExt.'.webp';
            $fullPath = storage_path('app/public/'.$webpPath);

            if (file_exists($fullPath)) {
                $url = asset('storage/'.$webpPath);
                static::$webpUrlCache[$filename] = $url;

                return $url;
            }
        }

        // Cache the fallback too
        $url = $this->url;
        static::$webpUrlCache[$filename] = $url;

        return $url;
    }
}
