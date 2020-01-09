<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\UsersServiceProvider;
use App\Providers\NfesServiceProvider;
use App\Providers\ArquiveiServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->register(UsersServiceProvider::class);
        $this->app->register(NfesServiceProvider::class);
        $this->app->register(ArquiveiServiceProvider::class);
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
