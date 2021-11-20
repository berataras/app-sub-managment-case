<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionEventsTable extends Migration
{
    public function up()
    {
        Schema::create('subscription_events', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            $table->integer('device_id');
            $table->string('event');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('subscription_events');
    }
}
