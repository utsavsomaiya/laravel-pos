<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceDiscount>
 */
class PriceDiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $discount = Discount::factory()->create();
        return [
            'discount_id' => $discount->id,
            'type' => $this->faker->boolean,
            'minimum_spend_amount' => $this->faker->numberBetween(50, 2000),
            'digit' => $this->faker->numberBetween(50, 2000),
        ];
    }
}
