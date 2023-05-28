<?php

namespace App\Providers;

use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //name variable inside service container
        $this->app->bind(CartRepository::class , function(){
            return new CartModelRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
