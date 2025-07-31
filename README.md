# Laravel Cart
[![Total Downloads](https://img.shields.io/packagist/dt/isapp/laravel-cart.svg?style=flat-square)](https://packagist.org/packages/isapp/laravel-cart)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/isapp/laravel-cart.svg?style=flat-square)](https://packagist.org/packages/isapp/laravel-cart)
[![TinyMCE Picture Tag Helper for Laravel](https://github.com/isap-ou/laravel-cart/blob/main/images/banner.jpg?raw=true)](https://github.com/isap-ou/laravel-cart)
**Laravel Cart** is a highly customizable package that enables you to easily add shopping cart functionality to your Laravel applications. With flexible options for item management, persistent storage, and deep integration with Laravel, it is perfect for building e-commerce or custom shopping features.

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
## Contributing

Contributions are welcome! If you have suggestions for improvements, new features, or find any issues, feel free to
submit a pull request or open an issue in this repository.

Thank you for helping make this package better for the community!

## License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).

You are free to use, modify, and distribute it in your projects, as long as you comply with the terms of the license.

---

Maintained by [ISAPP](https://isapp.be) and [ISAP OÜ](https://isap.me).  
Check out our software development services at [isap.me](https://isap.me).

