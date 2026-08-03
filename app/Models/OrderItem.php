<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'length_cm',
        'width_cm',
        'area',
        'size_unit',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'length_cm' => 'decimal:2',
        'width_cm' => 'decimal:2',
        'area' => 'decimal:4',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getHasSizeAttribute(): bool
    {
        return $this->size_unit !== null && $this->area !== null;
    }

    public function getSizeUnitLabelAttribute(): string
    {
        return $this->size_unit === 'm2' ? 'm²' : 'Cm²';
    }
}
