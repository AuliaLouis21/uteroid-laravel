<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => null,
            'size' => fake()->randomElement(['30x40cm', '40x60cm', '50x70cm', '60x90cm']),
            'thickness' => fake()->randomElement(['0.5mm', '1mm', '2mm']),
            'min_order' => fake()->numberBetween(100, 1000),
            'unit_price' => fake()->randomFloat(2, 5000, 500000),
            'description' => fake()->sentence(),
            'product_category_id' => ProductCategory::factory(),
            'product_type_id' => ProductType::factory(),
            'is_promo' => fake()->boolean(),
        ];
    }
}
