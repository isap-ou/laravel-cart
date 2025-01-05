<?php

namespace Isapp\LaravelCart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Isapp\LaravelCart\Models\CartItem;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

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
