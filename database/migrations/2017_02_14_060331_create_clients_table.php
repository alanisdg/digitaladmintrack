<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subclients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('type')->default(1);
            $table->string('email')->nullable();
            $table->string('direction')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();
            $table->integer('client_id')->unsigned()->default(1);
            $table->foreign('client_id')->references('id')->on('clients');
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
        Schema::dropIfExists('clients');
    }
}
