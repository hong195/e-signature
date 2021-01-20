<?php

namespace App\Providers;

use App\Observers\DepartmentObserver;
use App\Observers\UserSavedObserver;
use App\Services\HttpClient\Request\RequestInterface;
use App\Services\HttpClient\Request\GuzzleHttpRequest;
use App\Services\Yandex\SyncApiInterface;
use App\Services\Yandex\YandexService;
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
        $this->app->bind(RequestInterface::class, GuzzleHttpRequest::class);

        $this->app->when(DepartmentObserver::class)
                ->needs(SyncApiInterface::class)
                ->give(function() {
                    $endPoint = config('yandex.api_endpoint') . '/departments';
                    return new YandexService($this->app->make(RequestInterface::class), $endPoint);
                });

        $this->app->when(UserSavedObserver::class)
            ->needs(SyncApiInterface::class)
            ->give(function() {
                $endPoint = config('yandex.api_endpoint') . '/users';
                return new YandexService($this->app->make(RequestInterface::class), $endPoint);
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
