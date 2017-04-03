<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella events
class Events extends Migration {
    
    public function up() {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 100)->nullable();
            $table->dateTime('event_date_start');
            $table->dateTime('event_date_end');
            
            //foreign con la tabella bookings
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings');

            //foreign con la tabella tip_event
            $table->integer('tip_event_id')->unsigned();
            $table->foreign('tip_event_id')->references('id')->on('tip_event');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('events');
    }
    
}
