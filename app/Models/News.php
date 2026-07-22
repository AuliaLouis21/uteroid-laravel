<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'image', 'category_id', 'published_at'];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
