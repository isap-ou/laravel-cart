<?php

namespace IsapOu\LaravelCart\Tests\SetUp\Models;

use Binafy\LaravelCart\Cartable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IsapOu\LaravelCart\Contracts\CartItemProduct;
use IsapOu\LaravelCart\Tests\SetUp\Factories\ProductFactory;

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
     * @param bool $incTaxes
     * @return mixed
     */
    public function getPrice(bool $incTaxes = true)
    {
        return $this->price;
    }


    public static $factory = ProductFactory::class;
}
