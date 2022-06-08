<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftDiscount>
 */
class GiftDiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $discount = Discount::factory()->create();
        $product = Product::factory()->create();
        return [
            'discount_id' => $discount->id,
            'minimum_spend_amount' => $this->faker->numberBetween(50, 2000),
            'product_id' => $product->id,
        ];
    }
}
