<?php

namespace IsapOu\LaravelCart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use IsapOu\LaravelCart\Models\RedisModels\VirtualProduct;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class VirtualProductFactory extends Factory
{
    protected $model = VirtualProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
