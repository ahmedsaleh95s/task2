<?php

namespace App\Listeners;

use App\Events\StoreFirebaseEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Database;

class StoreFirebaseListener implements ShouldQueue
{
    private $database;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Database $database)
    {
        //
        $this->database = $database;
    }

    /**
     * Handle the event.
     *
     * @param  FirebaseEvent  $event
     * @return void
     */
    public function handle(StoreFirebaseEvent $event)
    {
        //
        $this->database->getReference($event->serviceProvider->id)->set($event->serviceProvider);
    }
}