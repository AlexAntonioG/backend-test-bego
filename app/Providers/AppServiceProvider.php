<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\UserServiceInterface::class,
            \App\Services\UserService::class
        );

        $this->app->bind(
            \App\Interfaces\TruckServiceInterface::class,
            \App\Services\TruckService::class
        );

        $this->app->bind(
            \App\Interfaces\OrderServiceInterface::class,
            \App\Services\OrderService::class
        );

        $this->app->bind(
            \App\Interfaces\LocationServiceInterface::class,
            \App\Services\LocationService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
