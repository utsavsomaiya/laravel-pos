<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory()->create([
            'username' => 'Laravel-Rajkot',
            'email' => 'laravel@rajkot.com',
            'password' => bcrypt('laravel_rajkot'),
        ]);
        $this->command->info('Admin Created successfully');

        $categories = Category::factory(10)->create();
        $this->command->info('Categories created successfully');

        Product::factory(25)
            ->productImage()
            ->sequence(static fn ($sequence) => [
                'category_id' => $categories->random(1)->first()->id,
            ])
            ->create();
        $this->command->info('Products created successfully');
    }
}
