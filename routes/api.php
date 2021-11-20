<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ReportController;
use \App\Http\Middleware\isAuth;


//Auth Process
Route::post('register', [RegisterController::class, 'register']);

//Purchase Process
Route::middleware([isAuth::class])->group(function() {
    Route::post('subscription/create', [SubscriptionController::class, 'createSubscription']);
    Route::post('subscription/check', [SubscriptionController::class, 'checkSubscription']);
});

Route::get('report', [ReportController::class, 'report']);
Route::get('report/excel', [ReportController::class, 'reportExcel']);
