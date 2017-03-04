<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullble();
            $table->string('description')->nullble();
            $table->dateTime('booking_date');
            
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users');
            
            $table->integer('id_event')->unsigned();
            $table->foreign('id_event')->references('id')->on('events');
            
            $table->integer('id_resource')->unsigned();
            $table->foreign('id_resource')->references('id')->on('resources');
            
            $table->integer('id_status')->unsigned();
            $table->foreign('id_status')->references('id')->on('tip_booking_status');
            
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
        Schema::dropIfExists('bookings');
    }
}
