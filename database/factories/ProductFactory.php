<?php

namespace Database\Factories;

use App\Domain\_shared\UUID;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * @return array|mixed[]
     */
    public function definition(): array
    {
        return [
            'uuid' => UUID::new(),
            'name' => fake()->name(),
            'price' => fake()->numberBetween(0, 5000), # 50.00 euro
        ];
    }
}
