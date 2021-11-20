<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceTokensTable extends Migration
{
    public function up()
    {
        Schema::create('device_tokens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid');
            $table->string('token');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('device_tokens');
    }
}
