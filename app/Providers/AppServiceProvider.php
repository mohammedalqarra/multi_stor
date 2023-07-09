<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();


        JsonResource::withoutWrapping(); // object not data

        // Paginator::defaultView('pagination.custom');
        Validator::extend('filter', function ($attribute, $value, $params) {
            //     if(strtolower($value) == 'laravel'){
            //         return false;
            //    }
            //         return True;
            return !in_array(strtolower($value), $params);
        }, ' The Value is prohibited!');
    }
}
