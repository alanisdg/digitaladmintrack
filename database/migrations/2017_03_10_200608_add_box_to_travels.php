<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBoxToTravels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travels', function (Blueprint $table) {
            $table->integer('box_id')->unsigned()->nullable();
            $table->foreign('box_id')->references('id')->on('devices');

            $table->integer('additionalbox_id')->unsigned()->nullable();
            $table->foreign('additionalbox_id')->references('id')->on('devices');

            $table->integer('boxs_number')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travels', function (Blueprint $table) {
            //
        });
    }
}
