<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table bookings
class Bookings extends Migration {
    
    public function up() {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id')->comment('booking id');  
            $table->string('name', 50)->nullable()->comment('booking name');  
            $table->string('description', 100)->nullable()->comment('booking description');  
            $table->dateTime('booking_date')->comment('booking date');         
            $table->integer('num_students')->comment('Expected number of students');  
            
            $table->string('subject_id', 20)->default('N.D.')->comment('reference subject');
            
            //foreign tip_event table
            $table->integer('tip_event_id')->unsigned()->comment('foreign tip_event table');  
            $table->foreign('tip_event_id')->references('id')->on('tip_event');
            
            //foreign user table
            $table->integer('user_id')->unsigned()->comment('foreign user table');    
            $table->foreign('user_id')->references('id')->on('users');
            
            //foreign resource table
            $table->integer('resource_id')->unsigned()->comment('foreign resource table');  
            $table->foreign('resource_id')->references('id')->on('resources');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('bookings');
    }
    
}
