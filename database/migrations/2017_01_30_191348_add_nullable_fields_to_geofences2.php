<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableFieldsToGeofences2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('geofences', function (Blueprint $table) {
             DB::statement('ALTER TABLE geofences MODIFY lat DOUBLE(15,8) NULL');
             DB::statement('ALTER TABLE geofences MODIFY lng DOUBLE(15,8) NULL');
             DB::statement('ALTER TABLE geofences MODIFY radius DOUBLE(15,8) NULL');
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
