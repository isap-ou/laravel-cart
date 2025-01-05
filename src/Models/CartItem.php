<?php

namespace Isapp\LaravelCart\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Isapp\LaravelCart\Concerns\HasCart;
use Isapp\LaravelCart\Concerns\Itemable;
use Isapp\LaravelCart\Contracts\CartItemContract;
use Isapp\LaravelCart\Database\Factories\CartItemFactory;

use function config;

class CartItem extends Model implements CartItemContract
{
    use HasCart;
    use HasFactory;
    use Itemable;

    protected static $factory = CartItemFactory::class;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('laravel-cart.cart_items_table_name', 'cart_items');
    }

    /**
     * Relation one-to-many, Cart model.
     */
    public function cart(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
