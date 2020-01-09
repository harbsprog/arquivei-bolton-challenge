<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\NfesRepositoryInterface;
use App\Repositories\NfesRepositoryEloquent;

class NfesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            NfesRepositoryInterface::class,
            NfesRepositoryEloquent::class
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
