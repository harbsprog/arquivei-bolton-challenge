<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ArquiveiRepositoryInterface;
use App\Repositories\ArquiveiRepositoryEloquent;
use App\Repositories\NfesRepositoryInterface;
use App\Repositories\NfesRepositoryEloquent;
use App\Repositories\UsersRepositoryInterface;
use App\Repositories\UsersRepositoryEloquent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ArquiveiRepositoryInterface::class,
            ArquiveiRepositoryEloquent::class
        );

        $this->app->bind(
            NfesRepositoryInterface::class,
            NfesRepositoryEloquent::class
        );

        $this->app->bind(
            UsersRepositoryInterface::class,
            UsersRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
