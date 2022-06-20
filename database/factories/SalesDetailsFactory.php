<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesDetails>
 */
class SalesDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $discount = Discount::factory()->create();
        $sales = Sales::factory()->create();
        $product = Product::factory()->create();
        return [
            'sales_id' => $sales->id,
            'product_discount_id' => $discount->id,
            'product_quantity' => $this->faker->numberBetween(0, 50),
            'product_id' => $product->id,
            'product_discount' => $this->faker->numberBetween(0, 1000)
        ];
    }
}
