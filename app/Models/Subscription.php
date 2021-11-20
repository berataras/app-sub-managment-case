<?php

namespace App\Models;

use F9Web\ApiResponseHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    use ApiResponseHelpers;

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
