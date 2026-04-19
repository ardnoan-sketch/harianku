<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'category_id' => \App\Models\Category::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 10000),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['income', 'expense']),
        ];
    }
}
