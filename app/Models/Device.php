<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function isHasDevice($uid){
        $device =  Device::where('uid', $uid)->first();
        if ($device){
            return DeviceToken::select('token')->where('uid', $device->uid)->first();
        }
    }
}
