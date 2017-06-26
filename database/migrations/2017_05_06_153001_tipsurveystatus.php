<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table "tip_survey_status"
class TipSurveyStatus extends Migration {
    
    public function up() {
        Schema::create('tip_survey_status', function (Blueprint $table) {
            $table->increments('id')->comment('tip_survey_status id');
            $table->string('description', 100)->comment('tip_survey_status description');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tip_survey_status');
    }
    
}
