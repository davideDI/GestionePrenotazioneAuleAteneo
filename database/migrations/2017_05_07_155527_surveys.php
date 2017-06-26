<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table surveys
class Surveys extends Migration {

    public function up() {
        
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id')->comment('survey id'); 
            $table->integer('real_num_students')->nullable()->comment('Real numbers of students'); 
            $table->string('note', 150)->nullable()->comment('surveys notes');
            
            //foreign bookings table
            $table->integer('repeat_id')->unsigned()->comment('repeat id'); 
            $table->foreign('repeat_id')->references('id')->on('repeats');
            
            $table->integer('requested_by')->comment('user who requires the operation');    
            $table->integer('performed_by')->nullable()->comment('user who submits the request');    
                        
            //foreign tip_survey_status table
            $table->integer('tip_survey_status_id')->unsigned()->comment('foreign tip_survey_status table');  
            $table->foreign('tip_survey_status_id')->references('id')->on('tip_survey_status');
             
            $table->timestamps();
        });
        
    }

    public function down() {
        
        Schema::dropIfExists('surveys');
        
    }
    
}
