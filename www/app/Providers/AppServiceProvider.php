<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
            'App\Repositories\ArquiveiRepositoryInterface',
            'App\Repositories\ArquiveiRepositoryEloquent'
        );

        $this->app->bind(
            'App\Repositories\NfesRepositoryInterface',
            'App\Repositories\NfesRepositoryEloquent'
        );

        $this->app->bind(
            'App\Repositories\UsersRepositoryInterface',
            'App\Repositories\UsersRepositoryEloquent'
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
