<?php

namespace IsapOu\LaravelCart\Tests\SetUp\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use IsapOu\LaravelCart\Tests\SetUp\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\AdminUsers\Models\User>
 */
class ProductFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'price' => $this->faker->randomNumber(0),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
