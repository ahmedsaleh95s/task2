<?php

namespace App\Listeners;

use App\Events\FirebaseEvent;
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

    /**
     * Handle the event.
     *
     * @param  FirebaseEvent  $event
     * @return void
     */
    public function handle($event)
    {
        //
        $deviceTokens = FcmToken::where('tokenable_type', 'App\Models\Admin')->pluck('fcm_token');
        Log::info($deviceTokens);
        if (!empty($deviceTokens)) {
            $messaging = app('firebase.messaging');
            $message = CloudMessage::new();
            $messaging->sendMulticast($message, $deviceTokens->toArray());
        }
    }
}
