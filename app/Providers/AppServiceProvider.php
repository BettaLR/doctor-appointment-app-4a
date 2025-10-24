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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the role middleware
        $router = $this->app['router'];
        $router->aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class);
    }
}
