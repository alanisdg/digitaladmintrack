<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPackets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('packets', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
            $table->integer('serviceType')->nullable();
            $table->integer('messageType')->nullable();
            $table->integer('altitude')->nullable();
            $table->integer('speed')->nullable();
            $table->integer('heading')->nullable();
            $table->integer('sat')->nullable();
            $table->integer('rssi')->nullable();
            $table->integer('eventIndex')->nullable();
            $table->integer('eventCode')->nullable();
            $table->integer('acumCount')->nullable();
            $table->integer('volt')->nullable();
            $table->integer('fuel1')->nullable();
            $table->integer('fuel2')->nullable();
            $table->integer('fuel3')->nullable();
            $table->integer('temp1')->nullable();
            $table->integer('temp2')->nullable();
            $table->integer('engine')->nullable();
            $table->integer('engine_block')->nullable();
            $table->integer('starter_block')->nullable();
            $table->integer('e_lock')->nullable();
            $table->integer('power_status')->nullable();
            $table->integer('low_bat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packets', function (Blueprint $table) {
            //
        });
    }
}
