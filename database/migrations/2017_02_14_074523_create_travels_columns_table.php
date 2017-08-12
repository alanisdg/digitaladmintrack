<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelsColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->integer('client_id')->unsigned()->default(1);
            $table->foreign('client_id')->references('id')->on('clients');

            $table->integer('route_id')->unsigned()->default(1);
            $table->foreign('route_id')->references('id')->on('routes');

            $table->integer('driver_id')->unsigned()->default(1);
            $table->foreign('driver_id')->references('id')->on('drivers');

            $table->integer('subclient_id')->unsigned()->default(1);
            $table->foreign('subclient_id')->references('id')->on('subclients');

            $table->integer('device_id')->unsigned()->default(1);
            $table->foreign('device_id')->references('id')->on('devices');

            $table->timestamp('departure_date')->nullable();
            $table->timestamp('arrival_date')->nullable();

            $table->integer('status')->unsigned()->default(0);


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
        Schema::dropIfExists('travels');
    }
}
