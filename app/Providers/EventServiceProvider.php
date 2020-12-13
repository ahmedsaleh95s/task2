<?php

namespace App\Providers;

use App\Events\DeleteFirebaseEvent;
use App\Events\StoreFirebaseEvent;
use App\Events\UpdateFirebaseEvent;
use App\Listeners\FcmListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        StoreFirebaseEvent::class => [
            FcmListener::class
        ],
        UpdateFirebaseEvent::class => [
            FcmListener::class
        ],
        DeleteFirebaseEvent::class => [
            FcmListener::class
        ]
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

    public function shouldDiscoverEvents()
    {
        return true;
    }
}
