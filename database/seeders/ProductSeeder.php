<?php

namespace Database\Seeders;

use App\Domain\_shared\UUID;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake();

        if (Product::query()->count() !== 0) {
            return;
        }

        $productImages = [
            'blackbook.jpg',
            'bluebook.jpg',
            'greenbook.jpg',
            'purplebook.jpg',
            'yellowbook.jpg',
            'redbook.jpg',
        ];

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->uuid = UUID::new();
            $product->name = $faker->name;
            $product->image = $productImages[array_rand($productImages)];
            $product->price = $faker->randomNumber(2); // between 0 and 20,00 euros
            $product->save();
        }
    }
}
