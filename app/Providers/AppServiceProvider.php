<?php

namespace App\Providers;

use App\Interfaces\AuthInterface;
use App\Repositories\AdminRepositories;
use App\Repositories\UserRepositories;
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
        //
        if (request()->is('api/admin/login')) {
            $this->app->bind(AuthInterface::class, AdminRepositories::class);
        }else {
            $this->app->bind(AuthInterface::class, UserRepositories::class);
        }
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
