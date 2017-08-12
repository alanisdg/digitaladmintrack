<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToRoutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->integer('origin_id')->unsigned()->nullable();
            $table->foreign('origin_id')->references('id')->on('geofences');

            $table->integer('destination_id')->unsigned()->nullable();
            $table->foreign('destination_id')->references('id')->on('geofences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {

        });
    }
}
