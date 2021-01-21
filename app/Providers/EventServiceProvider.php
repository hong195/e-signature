<?php

namespace App\Providers;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Listeners\ReSyncUser;
use App\Listeners\SyncUser;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserCreated::class => [
            SyncUser::class,
        ],
        UserUpdated::class => [
            ReSyncUser::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
