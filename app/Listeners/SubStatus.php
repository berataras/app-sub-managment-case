<?php

namespace App\Listeners;

use App\Models\SubscriptionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\SubEvent;
use Illuminate\Support\Facades\Http;

class SubStatus
{
    public function __construct()
    {
        //
    }

    public function handle(SubEvent $event)
    {
        $subsEvent = new SubscriptionEvent();
        $subsEvent->app_id = $event->app_id;
        $subsEvent->device_id = $event->device_id;
        $subsEvent->event = $event->event;
        $subsEvent->save();

        /*$response = Http::asForm()->post('http://127.0.0.1:8000/subscription/event', [
            'app_id' => $event->app_id,
            'device_id' => $event->device_id,
            'event' => $event->event
        ]);

        return $response->json();*/


    }
}
