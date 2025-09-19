# Laravel Cart
**Laravel Cart** is a highly customizable package that enables you to easily add shopping cart functionality to your Laravel applications. With flexible options for item management, persistent storage, and deep integration with Laravel, it is perfect for building e-commerce or custom shopping features.
[![Laravel cart](https://github.com/isap-ou/laravel-cart/blob/main/images/banner.jpg?raw=true)](https://github.com/isap-ou/laravel-cart)
[![Total Downloads](https://img.shields.io/packagist/dt/isapp/laravel-cart.svg?style=flat-square)](https://packagist.org/packages/isapp/laravel-cart)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/isapp/laravel-cart.svg?style=flat-square)](https://packagist.org/packages/isapp/laravel-cart)

## Features
- ✅ Persistent cart storage (database/session)
- ✅ Guest and authenticated user support
- ✅ High precision price calculations
- ✅ Model associations
- ✅ Method chaining
- ✅ Exception handling

## Installation

To install the package, use Composer:

```bash
composer require isapp/laravel-cart
```

## Publishing Configuration

To modify the default configuration, publish the configuration file using the following Artisan command:

```bash
php artisan vendor:publish --provider="Isapp\LaravelCart\CartServiceProvider" --tag="config"
```

This command will create a `config/laravel-cart.php` file where you can customize package settings as needed.

## Publishing and Running Migrations

To publish the migration files provided by the `Laravel Cart` package, use the following Artisan command:

```bash
php artisan vendor:publish --provider="Isapp\LaravelCart\CartServiceProvider" --tag="migrations"
```

This command will copy the migration files to your project's `database/migrations` directory.


### Running the Migrations

Once the migration files are published, you can apply the migrations to your database using the following command:

```bash
php artisan migrate
```

## Getting Started

### User Management

#### `getUser(): ?Authenticatable`
Returns the currently authenticated user or null if no user is set.

```php
$user = Cart::getUser();
```

#### `setUser(Authenticatable $user): Driver`
Sets a specific user for cart operations. Useful for admin operations or impersonation.

```php
$user = User::find(1);
Cart::setUser($user)->storeItem($item);
```

#### `setGuard(string $guard): Driver`
Sets the authentication guard to use (default is 'web').

```php
Cart::setGuard('admin')->getUser();
```

### Cart Management

#### `get(): Model|Cart`
Gets or creates the cart for the current user or session. For authenticated users, finds or creates cart by user_id. For guests, uses session_id.

```php
$cart = Cart::get();
echo "Cart has " . $cart->items->count() . " items";
```

### Item Storage

#### `storeItem(CartItemContract $item): Driver`
Stores a single item in the cart. If the item already exists, increases its quantity instead.

```php
$product = Product::find(1);
$cartItem = new CartItem();
$cartItem->itemable()->associate($product);
Cart::storeItem($cartItem);
```

**Throws:**
- `NotImplementedException` - if itemable doesn't implement CartItemProduct
- `ItemAssociatedWithDifferentCartException` - if trying to add item from another cart

#### `storeItems(Collection $items): static`
Stores multiple items in the cart at once.

```php
$items = collect([
    $cartItem1,
    $cartItem2,
    $cartItem3
]);
Cart::storeItems($items);
```

### Quantity Management

#### `increaseQuantity(CartItemContract $item, int $quantity = 1): static`
Increases the quantity of a specific cart item.

```php
// Increase by 1 (default)
Cart::increaseQuantity($cartItem);

// Increase by specific amount
Cart::increaseQuantity($cartItem, 5);
```

**Throws:**
- `NotFoundException` - if item doesn't exist in cart

#### `decreaseQuantity(CartItemContract $item, int $quantity = 1): Driver`
Decreases the quantity of a specific cart item.

```php
// Decrease by 1 (default)
Cart::decreaseQuantity($cartItem);

// Decrease by specific amount
Cart::decreaseQuantity($cartItem, 3);
```

**Throws:**
- `NotFoundException` - if item doesn't exist in cart

### Item Removal

#### `removeItem(CartItemContract $item): Driver`
Removes a specific item from the cart completely.

```php
Cart::removeItem($cartItem);
```

#### `emptyCart(): static`
Removes all items from the cart.

```php
Cart::emptyCart();
```

### Price Calculations

#### `getItemPrice(CartItemContract $item, bool $incTaxes = true): string`
Calculates the total price for a cart item (price × quantity). Returns a string for precision.

```php
// With taxes (default)
$totalPrice = Cart::getItemPrice($cartItem);

// Without taxes
$totalPrice = Cart::getItemPrice($cartItem, false);
```

#### `getItemPricePerUnit(CartItemContract $item, bool $incTaxes = true): string`
Gets the price per single unit of a cart item.

```php
// With taxes (default)
$unitPrice = Cart::getItemPricePerUnit($cartItem);

// Without taxes
$unitPrice = Cart::getItemPricePerUnit($cartItem, false);
```

#### `getTotalPrice(bool $incTaxes = true): string`
Calculates the total price of all items in the cart.

```php
// With taxes (default)
$total = Cart::getTotalPrice();

// Without taxes
$total = Cart::getTotalPrice(false);
```

### Usage Examples

#### Basic Cart Operations
```php
use Isapp\LaravelCart\Facades\Cart;
use App\Models\Product;
use Isapp\LaravelCart\Models\CartItem;

// Create and add item to cart
$product = Product::find(1);
$cartItem = new CartItem();
$cartItem->itemable()->associate($product);

Cart::storeItem($cartItem);

// Get cart with items
$cart = Cart::get();
echo "Items in cart: " . $cart->items->count();

// Calculate totals
$total = Cart::getTotalPrice();
echo "Cart total: $" . $total;
```

#### Working with Different Users
```php
// Admin adding items to user's cart
$user = User::find(123);
$product = Product::find(1);
$cartItem = new CartItem();
$cartItem->itemable()->associate($product);

Cart::setUser($user)->storeItem($cartItem);
```

#### Quantity Management
```php
// Get existing cart item
$cart = Cart::get();
$cartItem = $cart->items->first();

// Increase quantity
Cart::increaseQuantity($cartItem, 2);

// Decrease quantity
Cart::decreaseQuantity($cartItem, 1);

// Remove item completely
Cart::removeItem($cartItem);
```

#### Price Calculations
```php
$cart = Cart::get();

foreach ($cart->items as $item) {
    $unitPrice = Cart::getItemPricePerUnit($item);
    $totalItemPrice = Cart::getItemPrice($item);
    
    echo "Unit: $unitPrice, Total: $totalItemPrice\n";
}

$grandTotal = Cart::getTotalPrice();
echo "Grand Total: $grandTotal";
```

### Error Handling

The DatabaseDriver throws specific exceptions for different error conditions:

```php
use Isapp\LaravelCart\Exceptions\NotFoundException;
use Isapp\LaravelCart\Exceptions\NotImplementedException;
use Isapp\LaravelCart\Exceptions\ItemAssociatedWithDifferentCartException;

try {
    Cart::increaseQuantity($cartItem, 5);
} catch (NotFoundException $e) {
    // Item not found in cart
    return response()->json(['error' => 'Item not found'], 404);
} catch (NotImplementedException $e) {
    // Itemable doesn't implement required interface
    return response()->json(['error' => 'Invalid item'], 400);
} catch (ItemAssociatedWithDifferentCartException $e) {
    // Trying to add item from another cart
    return response()->json(['error' => 'Item belongs to different cart'], 400);
}
```

### Notes

- All price calculations use BCMath for high precision arithmetic
- Prices are returned as strings to maintain precision
- The driver supports both authenticated users and guest sessions
- Method chaining is supported for fluent interface
- Cart items must implement `CartItemProduct` interface
- The driver uses eager loading to optimize database queries

## Adding a Custom Driver to Laravel Facade via Extend

If you need to add a custom driver to the `Cart` facade, you can do so by extending it within a service provider.
Here is an example demonstrating how to achieve this:

1. Create a custom driver class, for example:

    ```php
    namespace App\Services;

    use Isapp\LaravelCart\Contracts\Driver;

    class CustomCartDriver implements Driver
    {
        // Implement methods as per the contract and your needs
        public function storeItem(CartItemContract $item): Driver
        {
            // Custom implementation
        }

        public function increaseQuantity(CartItemContract $item, int $quantity = 1): static
        {
            // Custom implementation
        }

        // Other required methods...
    }
    ```

2. Register the custom driver in a service provider:

    ```php
    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use Isapp\LaravelCart\Facades\Cart;

    class CartServiceProvider extends ServiceProvider
    {
        public function boot()
        {
            Cart::extend('custom', function () {
                return new \App\Services\CustomCartDriver;
            });
        }
    }
    ```
## ToDo List
- [ ] Add automated cleanup for expired cart sessions
- [ ] Add method to get total items count in cart
- [ ] Add method to get total quantity of all items
- [x] Add method to find item by ID
- [x] Add method to check if specific item exists in cart
- [ ] Add stock validation before adding items
- [ ] Add events firing (ItemAdded, ItemRemoved, etc.)
- [ ] Add method to merge carts (guest → user)

## Contributing

Contributions are welcome! If you have suggestions for improvements, new features, or find any issues, feel free to
submit a pull request or open an issue in this repository.

Thank you for helping make this package better for the community!

## License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).

You are free to use, modify, and distribute it in your projects, as long as you comply with the terms of the license.

---

Maintained by [ISAPP](https://isapp.be) and [ISAP OÜ](https://isap.me).  
Check out our software development services at [isapp.be](https://isapp.be).

