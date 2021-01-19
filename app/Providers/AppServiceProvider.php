<?php

namespace App\Providers;

use App\Services\ApiRequest\ApiRequestInterface;
use App\Services\ApiRequest\GuzzleHttp;
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
        $this->app->bind(ApiRequestInterface::class, GuzzleHttp::class);
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
