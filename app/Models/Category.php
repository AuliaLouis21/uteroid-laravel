<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\News;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function posts()
    {
        return $this->hasMany(News::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
