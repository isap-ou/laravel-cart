<?php

namespace Isapp\LaravelCart\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Isapp\LaravelCart\Exceptions\ItemAssociatedWithDifferentCartException;
use Isapp\LaravelCart\Facades\Cart;
use Isapp\LaravelCart\Models\CartItem;
use Isapp\LaravelCart\Tests\SetUp\Models\Product;
use Isapp\LaravelCart\Tests\SetUp\Models\User;
use Isapp\LaravelCart\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

use function xdebug_break;

class DatabaseDriverTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function addToCart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->newModel();
        $cartItem->itemable()->associate($product);
        $cart = Cart::setUser($user)->storeItem($cartItem)->get();

        $this->assertInstanceOf(\Isapp\LaravelCart\Models\Cart::class, $cart);
    }

    #[Test]
    public function addToCartGuest(): void
    {
        xdebug_break();
        Session::start();
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->newModel();
        $cartItem->itemable()->associate($product);
        $cart = Cart::storeItem($cartItem)->get();

        $this->assertNull($cart->user_id);
        $this->assertEquals($cart->session_id, Session::getId());
    }

    #[Test]
    public function addTheSameCartItem(): void
    {
        $user = User::factory()->create();
        Auth::login($user);
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->newModel();
        $cartItem->itemable()->associate($product);
        $cart = Cart::storeItem($cartItem)->get();
        $cart = Cart::storeItem($cart->items->first())->get();

        $this->assertEquals(2, $cart->items()->first()->quantity);
    }

    #[Test]
    public function addCartItemFromOtherCart(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        Auth::login($user);
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->newModel();
        $cartItem->itemable()->associate($product);
        $cartItem2 = CartItem::factory()->newModel();
        $cartItem2->itemable()->associate($product);
        $cart = Cart::storeItem($cartItem)->get();
        $this->expectException(ItemAssociatedWithDifferentCartException::class);
        Cart::setUser($user2)->storeItem($cartItem2)->storeItem($cart->items->first())->get();
    }

    #[Test]
    public function increaseQuantity(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->newModel();
        $cartItem->itemable()->associate($product);
        Cart::setUser($user)->storeItem($cartItem);
        $cart = Cart::setUser($user)->increaseQuantity($cartItem, 2)->get();

        $this->assertEquals(3, $cart->items()->first()->quantity);
    }
}
