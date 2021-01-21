<?php

namespace App\Providers;

use App\Services\ResourceService\Interfaces\ResourceServiceInterface;
use App\Services\SyncService\Interfaces\SynchronizerServiceInterface;
use App\Services\SyncService\Synchronizer;
use App\Services\ResourceService\YandexResource;
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
        $this->app->bind(ResourceServiceInterface::class, YandexResource::class);
        $this->app->bind(SynchronizerServiceInterface::class, Synchronizer::class);
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
