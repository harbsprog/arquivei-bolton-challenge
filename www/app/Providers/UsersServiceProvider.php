<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UsersRepositoryInterface;
use App\Repositories\UsersRepositoryEloquent;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UsersRepositoryInterface::class,
            UsersRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
