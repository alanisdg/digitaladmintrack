<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('devices_id')->unsigned();
            $table->bigInteger('imei')->unsigned();
            $table->string('buffer', 200);
            $table->double('lat', 15, 8);
            $table->double('lng', 15, 8);
            $table->timestamps();
            $table->foreign('devices_id')->references('id')->on('devices');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packets');
    }
}
