<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipSurveyStatus extends Model {
    
    protected $table = "tip_survey_status";
    
    //Relazione con la tabella repeats
    public function repeats() {
        return $this->hasMany('App\Repeat');
    }
    
}
