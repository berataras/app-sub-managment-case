<?php

namespace App\Http\Middleware;

use App\Models\Device;
use App\Models\DeviceToken;
use Closure;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

class isAuth
{
    use ApiResponseHelpers;
    public function handle(Request $request, Closure $next)
    {
        $authToken = $request->bearerToken();
        $deviceToken = DeviceToken::where('token', $authToken)->first();
        if ($deviceToken){
            $device = Device::where('uid', $deviceToken->uid)->first();
            $request->attributes->add(['device' => $device]);
            return $next($request);
        }else{
            return $this->respondUnAuthenticated();
        }

    }
}
