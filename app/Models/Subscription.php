<?php

namespace App\Models;

use F9Web\ApiResponseHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    use ApiResponseHelpers;

    static public function subReport(){
         return Subscription::selectRaw('subscriptions.app_id, event, os, count(event) as total_event')
            ->join('subscription_events', 'subscription_events.app_id', 'subscriptions.app_id')
            ->join('devices', 'devices.uid', 'subscriptions.uid')
            ->groupBy('subscriptions.app_id', 'os', 'event')->get();
    }

    public function isSubUser($app_id){
        $isSub = Subscription::where('app_id', $app_id)->first();
        if ($isSub){
            return $isSub;
        }else{
            return false;
        }
    }

    public function getSubInfo($status, $expire_date){
        return $this->respondWithSuccess(
            [
                'status' => $status,
                'expeire_date' => $expire_date
            ]
        );
    }
}
