# Laravel Cart

**Laravel Cart** is a highly customizable package that enables you to easily add shopping cart functionality to your Laravel applications. With flexible options for item management, persistent storage, and deep integration with Laravel, it is perfect for building e-commerce or custom shopping features.

## Installation

To install the package, use Composer:

```bash
composer require isap-ou/laravel-cart
```

## Publishing Configuration

To modify the default configuration, publish the configuration file using the following Artisan command:

```bash
php artisan vendor:publish --provider="IsapOu\LaravelCart\CartServiceProvider" --tag="config"
```

This command will create a `config/laravel-cart.php` file where you can customize package settings as needed.

## Publishing and Running Migrations

To publish the migration files provided by the `Laravel Cart` package, use the following Artisan command:

```bash
php artisan vendor:publish --provider="IsapOu\LaravelCart\CartServiceProvider" --tag="migrations"
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

    use IsapOu\LaravelCart\Contracts\Driver;

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
    use IsapOu\LaravelCart\Facades\Cart;

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

Feel free to submit issues, fork the repository, and create pull requests.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

