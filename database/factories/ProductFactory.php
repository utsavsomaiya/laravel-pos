<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Throwable;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tax = [5,10,15,20,25];

        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->numberBetween(50, 1000),
            'category_id' => fn() => Category::factory()->create()->id,
            'stock' => $this->faker->numberBetween(0, 50),
            'tax' => $tax[array_rand($tax, 1)]
        ];
    }

    public function productImage(): self
    {
        try {
            return $this->afterCreating(function (Product $product): void {
                $imageUrl = 'https://placeimg.com/200/200/any';
                $product
                    ->addMediaFromUrl($imageUrl)
                    ->toMediaCollection('product-images');
            });
        } catch (Throwable) {
            return $this;
        }
    }
}
