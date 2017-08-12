<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('direction')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();
            $table->integer('subclients_id')->unsigned()->nullable();
            $table->foreign('subclients_id')->references('id')->on('subclients');

            $table->integer('geofences_id')->unsigned()->nullable();
            $table->foreign('geofences_id')->references('id')->on('geofences');


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
        Schema::dropIfExists('locations');
    }
}
