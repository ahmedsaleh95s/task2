<?php

namespace App\Providers;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\UserController;
use App\Interfaces\AuthInterface;
use App\Repositories\AdminRepositories;
use App\Repositories\ServiceProviderRepositories;
use App\Repositories\UserRepositories;
use Illuminate\Support\ServiceProvider;
use App\Services\AuthService;

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
        $this->app->when(AdminController::class)
            ->needs(AuthInterface::class)
            ->give(function () {
                return app(AdminRepositories::class);
            });

        $this->app->when(UserController::class)
            ->needs(AuthInterface::class)
            ->give(function () {
                return app(UserRepositories::class);
            });

        $this->app->when(ServiceProviderController::class)
            ->needs(AuthInterface::class)
            ->give(function () {
                return app(ServiceProviderRepositories::class);
            });
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
