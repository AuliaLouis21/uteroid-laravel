<?php

namespace Tests\Unit;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_belongs_to_category(): void
    {
        $category = ProductCategory::factory()->create(['name' => 'Kardus']);
        $product = Product::factory()->create(['product_category_id' => $category->id]);

        $this->assertInstanceOf(ProductCategory::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    public function test_product_belongs_to_type(): void
    {
        $type = ProductType::factory()->create(['name' => 'Single Face']);
        $product = Product::factory()->create(['product_type_id' => $type->id]);

        $this->assertInstanceOf(ProductType::class, $product->type);
        $this->assertEquals($type->id, $product->type->id);
    }

    public function test_product_has_many_images(): void
    {
        $product = Product::factory()->create();

        ProductImage::factory()->count(3)->create(['product_id' => $product->id]);

        $this->assertCount(3, $product->images);
        $this->assertInstanceOf(ProductImage::class, $product->images->first());
    }

    public function test_product_has_many_order_items(): void
    {
        $product = Product::factory()->create();

        OrderItem::factory()->count(2)->create(['product_id' => $product->id]);

        $this->assertCount(2, $product->orderItems);
        $this->assertInstanceOf(OrderItem::class, $product->orderItems->first());
    }

    public function test_product_has_correct_fillable_fields(): void
    {
        $product = new Product();

        $this->assertEquals([
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
        ], $product->getFillable());
    }
}
