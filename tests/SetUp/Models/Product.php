<?php

namespace Isapp\LaravelCart\Tests\SetUp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Isapp\LaravelCart\Contracts\CartItemProduct;
use Isapp\LaravelCart\Tests\SetUp\Factories\ProductFactory;

class Product extends Model implements CartItemProduct
{
    use HasFactory;

    protected $table = 'test_products';

    /**
     * Fillable columns.
     *
     * @var string[]
     */
    protected $fillable = ['title', 'price'];

    /**
     * Get the correct price.
     *
     * @return mixed
     */
    public function getPrice(bool $incTaxes = true)
    {
        return $this->price;
    }

    public static $factory = ProductFactory::class;
}
