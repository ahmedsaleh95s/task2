<?php

namespace App\Listeners;

use App\Events\UpdateFirebaseEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Database;

class UpdateFirebaseListener implements ShouldQueue
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
     * @param  UpdateFirebaseEvent  $event
     * @return void
     */
    public function handle(UpdateFirebaseEvent $event)
    {
        //
        $updates = [$event->serviceProvider->id => $event->serviceProvider];
        $this->database->getReference() // this is the root reference
            ->update($updates);
    }
}
