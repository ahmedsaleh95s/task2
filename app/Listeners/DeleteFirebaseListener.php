<?php

namespace App\Listeners;

use App\Events\DeleteFirebaseEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Database;

class DeleteFirebaseListener implements ShouldQueue
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
     * @param  DeleteFirebaseEvent  $event
     * @return void
     */
    public function handle(DeleteFirebaseEvent $event)
    {
        //
        $this->database->getReference($event->serviceProvider->id)->remove();
    }
}
