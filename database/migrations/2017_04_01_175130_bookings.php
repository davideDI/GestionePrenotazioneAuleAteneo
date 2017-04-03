<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella bookings
class Bookings extends Migration {
    
    public function up() {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->nullble();
            $table->string('description', 100)->nullble();
            $table->dateTime('booking_date');
            
            $table->dateTime('event_date_start');
            $table->dateTime('event_date_end');
            
            //foreign con la tabella tip_event
            $table->integer('tip_event_id')->unsigned();
            $table->foreign('tip_event_id')->references('id')->on('tip_event');
            
            //foreign con la tabella user
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            
            //foreign con la tabella resource
            $table->integer('resource_id')->unsigned();
            $table->foreign('resource_id')->references('id')->on('resources');
            
            //foreign con la tabella tip_booking_status
            $table->integer('tip_booking_status_id')->unsigned();
            $table->foreign('tip_booking_status_id')->references('id')->on('tip_booking_status');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('bookings');
    }
    
}
