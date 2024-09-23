<?php

namespace Database\Seeders;

use App\Domain\_shared\UUID;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('products')->insert([
                'uuid' => UUID::new(),
                'name' => fake('en_US')->word,
                'price' => fake()->randomNumber(4),
                'created_at' => now(),
            ]);
        }
    }
}
