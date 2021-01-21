<?php

namespace App\Providers;

use App\Services\SyncService\SyncInterface;
use App\Services\SyncService\UserSync;
use App\Services\SyncService\UserSyncInterface;
use App\Services\SyncService\Yandex\YandexService;
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
        $this->app->bind(SyncInterface::class, YandexService::class);
        $this->app->bind(UserSyncInterface::class, UserSync::class);
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
