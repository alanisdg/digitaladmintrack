<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeofencesHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signes', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('packet_id')->unsigned()->nullable();


            $table->integer('geofence_id')->unsigned()->nullable();
            $table->foreign('geofence_id')->references('id')->on('geofences');

            $table->integer('device_id')->unsigned()->nullable();
            $table->foreign('device_id')->references('id')->on('devices');





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
        Schema::dropIfExists('geofence_history');
    }
}
