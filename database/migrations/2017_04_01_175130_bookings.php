<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table bookings
class Bookings extends Migration {
    
    public function up() {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id')->comment('bookings id');  
            $table->string('name', 50)->nullble()->comment('bookings name');  
            $table->string('description', 100)->nullble()->comment('bookings description');  
            $table->dateTime('booking_date')->comment('booking date');  
            
            $table->dateTime('event_date_start')->comment('start date');  
            $table->dateTime('event_date_end')->comment('start end');  
            
            $table->integer('num_students')->comment('Expected number of students');
            $table->smallInteger('rep_num_weeks')->default(1)->comment('Number of repetitions');  
            
            //foreign tip_event table
            $table->integer('tip_event_id')->unsigned()->comment('foreign tip_event table');  
            $table->foreign('tip_event_id')->references('id')->on('tip_event');
            
            //foreign user table
            $table->integer('user_id')->unsigned()->comment('foreign user table');    
            $table->foreign('user_id')->references('id')->on('users');
            
            //foreign resource table
            $table->integer('resource_id')->unsigned()->comment('foreign resource table');  
            $table->foreign('resource_id')->references('id')->on('resources');
            
            //foreign tip_booking_status table
            $table->integer('tip_booking_status_id')->unsigned()->comment('foreign tip_booking_status table');  
            $table->foreign('tip_booking_status_id')->references('id')->on('tip_booking_status');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('bookings');
    }
    
}
