<?php

namespace App\Listeners;

use App\Events\DeleteFirebaseEvent;
use App\Events\StoreFirebaseEvent;
use App\Events\UpdateFirebaseEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Log;
use App\Models\FcmToken;

class FcmListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handleStoreFirebaseEvent($event) {
        $this->handle();
    }

    public function handleUpdateFirebaseEvent($event) {
        $this->handle();
    }

    public function handleDeleteFirebaseEvent($event) {
        $this->handle();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            StoreFirebaseEvent::class,
            [FcmListener::class, 'handleStoreFirebaseEvent']
        );

        $events->listen(
            UpdateFirebaseEvent::class,
            [FcmListener::class, 'handleUpdateFirebaseEvent']
        );

        $events->listen(
            DeleteFirebaseEvent::class,
            [FcmListener::class, 'handleDeleteFirebaseEvent']
        );
    }

    /**
     * Handle the event.
     *
     * @param  FirebaseEvent  $event
     * @return void
     */
    public function handle()
    {
        //
        $deviceTokens = FcmToken::where('tokenable_type', 'App\Models\Admin')->pluck('fcm_token');
        Log::info($deviceTokens);
        if (!empty($deviceTokens)) {
            $messaging = app('firebase.messaging');
            $message = CloudMessage::new();
            $messaging->sendMulticast($message, $deviceTokens->toArray());
            $result = $messaging->subscribeToTopic('Firebase', $deviceTokens->toArray());
            Log::info($result);
        }
    }
}
