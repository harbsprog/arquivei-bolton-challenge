<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ArquiveiRepositoryInterface;
use App\Repositories\ArquiveiRepositoryEloquent;

class ArquiveiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ArquiveiRepositoryInterface::class,
            ArquiveiRepositoryEloquent::class
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
