<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationDevicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->date('installation_date');
            $table->time('installation_hour');
            $table->date('remove_date');
            $table->time('remove_hour');
            $table->string('latitude');
            $table->string('length');
            $table->integer('device_id')->unsigned();
            $table->integer('area_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('device_id')->references('id')->on('devices');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('location_devices');
    }
}
