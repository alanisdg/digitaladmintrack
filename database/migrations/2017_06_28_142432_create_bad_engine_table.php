<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadEngineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bengines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned()->nullable();
            $table->foreign('device_id')->references('id')->on('devices');

            $table->bigInteger('packet_id')->unsigned()->nullable();
            $table->foreign('packet_id')->references('id')->on('packets');

            $table->integer('bad')->unsigned()->nullable();
            $table->timestamp('updateTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bengines');
    }
}
