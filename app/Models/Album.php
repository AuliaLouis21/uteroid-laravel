<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class);
    }

    public function videos()
    {
        return $this->hasMany(AlbumVideo::class);
    }

    public function audios()
    {
        return $this->hasMany(AlbumAudio::class);
    }
}
