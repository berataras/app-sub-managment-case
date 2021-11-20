<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SubscriptionController;
use \App\Http\Middleware\isAuth;


//Auth Process
Route::post('register', [RegisterController::class, 'register']);

//Purchase Process
Route::middleware([isAuth::class])->group(function() {
    Route::post('subscription/create', [SubscriptionController::class, 'createSubscription']);
    Route::post('subscription/check', [SubscriptionController::class, 'checkSubscription']);
});

Route::post('subscription/event', [SubscriptionController::class, 'eventSubscription']);
