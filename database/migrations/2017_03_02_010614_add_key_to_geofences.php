<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeyToGeofences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geofences', function (Blueprint $table) {
            $table->integer('gcat_id')->unsigned()->nullable();
            $table->foreign('gcat_id')->references('id')->on('gcats');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geofences', function (Blueprint $table) {
            //
        });
    }
}
