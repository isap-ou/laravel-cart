<?php

namespace IsapOu\LaravelCart\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use IsapOu\LaravelCart\Facades\Cart;
use IsapOu\LaravelCart\Models\CartItem;
use IsapOu\LaravelCart\Models\RedisModels\VirtualProduct;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

use function xdebug_break;

class CartTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function addToCart()
    {
        $user = \App\AdminUsers\Models\User::factory()->create();

        $virtualProduct = new VirtualProduct();
        $virtualProduct->save();
        $cartItem = CartItem::factory()->newModel();
        $cartItem->itemable()->associate($virtualProduct);
        $cart = Cart::storeItem($cartItem, $user)->get($user);

        $this->assertInstanceOf(\IsapOu\LaravelCart\Models\Cart::class, $cart);
    }

    #[Test]
    public function increaseQuantity()
    {
        $user = \App\AdminUsers\Models\User::factory()->create();
        $virtualProduct = new VirtualProduct();
        $virtualProduct->save();
        $cartItem = CartItem::factory()->newModel();
        $cartItem->itemable()->associate($virtualProduct);
        Cart::storeItem($cartItem, $user);
        $cart = Cart::increaseQuantity($cartItem, $user, 2)->get($user);

        $this->assertEquals(3, $cart->items()->first()->quantity);
    }
}
