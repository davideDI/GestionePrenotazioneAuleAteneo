<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table surveys
class Surveys extends Migration {

    public function up() {
        
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id')->comment('survey id'); 
            $table->integer('real_num_students')->comment('Real numbers of students'); 
            $table->string('note', 150)->comment('surveys notes');
            
            //foreign bookings table
            $table->integer('booking_id')->unsigned()->comment('booking id'); 
            $table->foreign('booking_id')->references('id')->on('bookings');
            
            //foreign users table
            $table->integer('user_id')->unsigned()->comment('foreign user table');    
            $table->foreign('user_id')->references('id')->on('users');
             
            $table->timestamps();
        });
        
    }

    public function down() {
        
        Schema::dropIfExists('surveys');
        
    }
    
}
