<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thits', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('travel_id')->unsigned()->nullable();
            $table->foreign('travel_id')->references('id')->on('travels');

            $table->integer('tcode_id')->unsigned()->nullable();
            $table->foreign('tcode_id')->references('id')->on('tcodes');

            $table->integer('packet_id')->unsigned()->nullable();

            $table->integer('geofence_id')->unsigned()->nullable();
            $table->foreign('geofence_id')->references('id')->on('geofences');




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
        Schema::dropIfExists('thits');
    }
}
