<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeofencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        Schema::create('geofences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',200);
            $table->enum('type', ['poly', 'circle']);
            $table->double('lat', 15, 8);
            $table->double('lng', 15, 8);
            $table->double('radius', 15, 8);
            $table->integer('id_client');
            $table->longText('poly_data');
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
        Schema::dropIfExists('geofences');
    }
}
