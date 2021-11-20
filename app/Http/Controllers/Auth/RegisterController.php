<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;

class RegisterController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(Device $device, DeviceToken $deviceToken)
    {
        $this->device = $device;
        $this->deviceToken = $deviceToken;
    }

    public function register(Request $request){
        $isHasDevice = $this->device->isHasDevice($request->uid);
        if ($isHasDevice){
            return $this->respondOk($isHasDevice->token);
        }

        $createDevice = $this->device->create($request->input());

        $this->deviceToken->uid = $createDevice->uid;
        $this->deviceToken->token = $this->deviceToken->tokenGenerate();
        $this->deviceToken->save();

        return $this->respondWithSuccess(['token' => $this->deviceToken->token]);
    }
}
