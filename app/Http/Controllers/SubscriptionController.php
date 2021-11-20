<?php

namespace App\Http\Controllers;

use App\Events\SubEvent;
use App\Models\Subscription;
use App\Models\SubscriptionEvent;
use Carbon\Carbon;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(Subscription $subscription, SubscriptionEvent $event)
    {
        $this->subscription = $subscription;
        $this->event = $event;
    }

    public function createSubscription(Request $request){
        $device = $request->get('device');
        //receipt'in son karakterini al
        $receiptLastNumb = substr($request->receipt, -1);
        //son iki rakamı al
        $receiptTwoNumb = substr($request->receipt, -2);
        //1 aylık abonelik
        $expire_date = Carbon::now()->addDays(30);

        //receipt son iki rakan 6'ya bölünüyorsa ios, google rate_limit hatası
        if ($receiptTwoNumb % 6 == 0){
            return $this->respondError('rate_limit');
        }

        //receipt'in son rakamı tek ise googe ve ios doğrulandı.
        if ($receiptLastNumb % 2 != 0){

            //Eğer sub ise ve expire_date'i daha dolmamışsa tekrar sub olamaz.
            $isSub = $this->subscription->isSubUser($request->app_id);
            if ($isSub){
                if ($isSub && !Carbon::parse($isSub->expire_date)->isPast()){
                    return $this->respondOk('user_has_subscription');
                }elseif($isSub && Carbon::parse($isSub->expire_date)->isPast()){
                    event(new SubEvent($isSub->app_id, $isSub->uid, 'renewed'));
                    $isSub->delete();
                }
            }

            $this->subscription->uid = $device->uid;
            $this->subscription->app_id = $request->app_id;
            $this->subscription->expire_date = $expire_date;
            $this->subscription->status = 1;
            $this->subscription->save();
            if (!$isSub){
                //started event'i gönderiliyor.
                event(new SubEvent($this->subscription->app_id, $this->subscription->uid, 'started'));
            }
            //sonucu kayıt et ve döndür.
            return $this->subscription->getSubInfo($this->subscription->status, $expire_date);
        }else{
            //google, ios doğrulaması olmadıysa false döndür.
            return $this->respondError('false');
        }
    }

    public function checkSubscription(Request $request){
        $device = $request->get('device');
        $subscription = Subscription::where('uid', $device->uid)->first();

        //sub var ise
        if ($this->subscription->isSubUser($request->app_id)){
            //son kullanım tarihi geçmişse
            if (Carbon::parse($subscription->expire_date)->isPast()){
                $subscription->status = 0;
                $subscription->save();
                //canceled event'i gönderiliyor.
                event(new SubEvent($subscription->app_id, $subscription->uid, 'canceled'));
            }
            //sub durumunu döndür
            return $this->subscription->getSubInfo($subscription->status, $subscription->expire_date);
        }else{
            //sub yoksa has_not
            return $this->respondError('user_has_not_subcription');
        }
    }

    public function eventSubscription(Request $request){
        $create = $this->event->create($request->input());

        if ($create){
            return $this->respondWithSuccess($create);
        }else{
            return $this->respondError();
        }
    }
}
