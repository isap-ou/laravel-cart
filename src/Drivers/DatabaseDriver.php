<?php

namespace Isapp\LaravelCart\Drivers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Isapp\LaravelCart\Contracts\CartItemContract;
use Isapp\LaravelCart\Contracts\CartItemProduct;
use Isapp\LaravelCart\Contracts\Driver;
use Isapp\LaravelCart\Exceptions\ItemAssociatedWithDifferentCartException;
use Isapp\LaravelCart\Exceptions\NotFoundException;
use Isapp\LaravelCart\Exceptions\NotImplementedException;
use Isapp\LaravelCart\Models\Cart;

use function bcadd;
use function bcmul;
use function bcpow;
use function class_implements;
use function config;
use function method_exists;

class DatabaseDriver implements Driver
{
    protected ?Authenticatable $user = null;

    protected string $guard = 'web';

    public function __construct()
    {
        $this->guard = config('laravel-cart.guard');
    }

    public function getUser(): ?Authenticatable
    {
        if (empty($this->user)) {
            $this->user = Auth::guard($this->guard)->user();
        }

        return $this->user;
    }

    public function setUser(Authenticatable $user): Driver
    {
        $this->user = $user;

        return $this;
    }

    public function setGuard($guard): Driver
    {
        $this->guard = $guard;

        return $this;
    }

    public function get(): Model|Cart
    {
        return $this->getCartModel()
            ->with('items.itemable')
            ->when(
                ! empty($this->getUser()),
                fn ($query) => $query->firstOrCreate(['user_id' => $this->getUser()->getKey()]),
                fn ($query) => $query->firstOrCreate(['session_id' => Session::getId()])
            );
    }

    /**
     * Store item in cart.
     *
     * @throws NotFoundException
     * @throws NotImplementedException
     * @throws ItemAssociatedWithDifferentCartException
     */
    public function storeItem(CartItemContract $item): Driver
    {
        if (! \in_array(CartItemProduct::class, class_implements($item->itemable), true)) {
            throw new NotImplementedException('Itemable must implement CartItemProduct');
        }

        $cart = $this->get();

        if ($item->exists) {
            if (! $cart->items->contains($item)) {
                throw new ItemAssociatedWithDifferentCartException('The item belongs to another cart');
            }

            return $this->increaseQuantity($item);
        }

        $cart->items()->save($item);

        return $this;
    }

    /**
     * Store multiple items in cart.
     */
    public function storeItems(Collection $items): static
    {
        $items->each(fn (CartItemContract $item) => $this->storeItem($item));

        return $this;
    }

    /**
     * Increase the quantity of the item.
     *
     * @throws NotFoundException
     */
    public function increaseQuantity(CartItemContract $item, int $quantity = 1): static
    {
        $item = $this->get()->items()->find($item->getKey());

        if (! $item) {
            throw new NotFoundException('The item not found');
        }

        $item->increment('quantity', $quantity);

        return $this;
    }

    /**
     * Decrease the quantity of the item.
     *
     * @throws NotFoundException
     */
    public function decreaseQuantity(CartItemContract $item, int $quantity = 1): Driver
    {
        $item = $this->get()->items()->find($item->getKey());

        if (! $item) {
            throw new NotFoundException('The item not found');
        }

        $item->decrement('quantity', $quantity);

        return $this;
    }

    /**
     * Remove a single item from the cart
     */
    public function removeItem(CartItemContract $item): Driver
    {
        $this->get()->items()
            ->find($item->getKey())
            ?->delete();

        return $this;
    }

    /**
     * Remove every item from the cart
     */
    public function emptyCart(): static
    {
        $this->get()?->items()->delete();

        return $this;
    }

    public function getTotalPrice(bool $incTaxes = true): string
    {
        $totalPrice = '0';
        $cart = $this->get();

        $cartScaleFactor = bcpow('10', (string) $cart->decimal_places);

        /** @var CartItemContract $item */
        foreach ($cart->items()->cursor() as $item) {
            if (! method_exists($item->itemable, 'getPrice')) {
                continue;
            }

            $itemScaleFactor = bcpow('10', (string) $item->decimal_places);
            $pricePerUnit = bcmul(
                (string) $item->itemable->getPrice($incTaxes),
                (string) $item->quantity,
                $itemScaleFactor
            );

            $totalPrice = bcadd($totalPrice, $pricePerUnit, $cartScaleFactor);
        }

        return $totalPrice;
    }

    protected function getCartModel(): Builder
    {
        $class = config('laravel-cart.drivers.database.cart_model');

        return $class::query();
    }
}
