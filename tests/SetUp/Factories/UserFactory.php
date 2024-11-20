<?php

namespace IsapOu\LaravelCart\Tests\SetUp\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use IsapOu\LaravelCart\Tests\SetUp\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\AdminUsers\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
        ];
    }
}
