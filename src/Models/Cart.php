<?php

namespace Isapp\LaravelCart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function config;

class Cart extends Model
{
    protected $fillable = [
        'decimal_places',
        'session_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('laravel-cart.cart_table_name', 'carts');
        if (! empty(config('laravel-cart.migration.users'))) {
            $this->fillable[] = config('laravel-cart.migration.users.foreign_key', 'user_id');
        }
        if (! empty(config('laravel-cart.migration.teams'))) {
            $this->fillable[] = config('laravel-cart.migration.teams.foreign_key', 'team_id');
        }
    }

    public function items(): HasMany
    {
        return $this->hasMany(config('laravel-cart.drivers.database.cart_item_model'));
    }
}
