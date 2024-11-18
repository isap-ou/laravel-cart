<?php

namespace IsapOu\LaravelCart\Models\RedisModels;

use Alvin0\RedisModel\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use IsapOu\LaravelCart\Models\CartItem;

class VirtualProduct extends Model
{
    use HasFactory;

    /**
     * The model's sub keys for the model.
     *
     * @var array
     */
    protected $subKeys = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
    ];

    protected static $factory = VirtualProduct::class;

    public function cartItems()
    {
        return $this->morphMany(CartItem::class, 'itemable');
    }

    protected static function preventsAccessingMissingAttributes(): bool
    {
        return false;
    }
}
