<?php

namespace IsapOu\LaravelCart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use IsapOu\LaravelCart\Concerns\HasUser;

use function config;

class Cart extends Model
{
    use HasUser;

    protected $fillable = [
        'decimal_places',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('laravel-cart.cart_table_name', 'carts');
        if (! empty(config('laravel-cart.migration.users'))) {
            $this->fillable[] = config('laravel-cart.migration.users.foreign_key', 'id');
        }
    }

    public function items(): HasMany
    {
        return $this->hasMany(config('laravel-cart.drivers.database.cart_items_model'));
    }
}
