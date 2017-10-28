<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class Repeats extends Migration {

    public function up() {
        
        Schema::create('repeats', function (Blueprint $table) {
            $table->increments('id')->comment('repeat id'); 
            
            $table->dateTime('event_date_start')->comment('start date');  
            $table->dateTime('event_date_end')->comment('end date');  
            
            //foreign bookings table
            $table->integer('booking_id')->unsigned()->comment('booking id'); 
            $table->foreign('booking_id')->references('id')->on('bookings');
            
            //foreign tip_booking_status table
            $table->integer('tip_booking_status_id')->unsigned()->comment('foreign tip_booking_status table');  
            $table->foreign('tip_booking_status_id')->references('id')->on('tip_booking_status');
            
            $table->timestamps();
        });
        
    }

    public function down() {
        
        Schema::dropIfExists('repeats');
    
    }
    
}
