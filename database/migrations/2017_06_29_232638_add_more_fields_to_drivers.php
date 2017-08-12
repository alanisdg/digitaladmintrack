<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToDrivers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->text('image_licence')->nullable();
            $table->text('thumb_image_licence')->nullable();

            $table->text('image_test')->nullable();
            $table->text('thumb_image_test')->nullable();

            $table->date('driver_first_day')->nullable();
            $table->date('driver_last_day')->nullable();
            $table->date('driver_test_validity')->nullable();

            $table->text('driver_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drivers', function (Blueprint $table) {
            //
        });
    }
}
