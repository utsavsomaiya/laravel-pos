<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales>
 */
class SalesFactory extends Factory
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
            'subtotal' => $this->faker->numberBetween(0, 1000),
            'total_discount' => $this->faker->numberBetween(0, 1000),
            'total_tax' => $this->faker->numberBetween(0, 1000),
            'discount_id' => $discount->id,
            'total' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
