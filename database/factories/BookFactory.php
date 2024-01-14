<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quantity' => rand(1, 8),
            'title' => fake()->name(),
            'price' => fake()->randomNumber(3) // in cents
        ];
    }
}
