<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use HasFactory;

    public function tokenGenerate(){
        return sha1(mt_rand(1, 90000) . 'SALT');
    }
}
