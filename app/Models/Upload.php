<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'filename', 'disk', 'uploadable_id', 'uploadable_type'];

    public function uploadable()
    {
        return $this->morphTo();
    }
}
