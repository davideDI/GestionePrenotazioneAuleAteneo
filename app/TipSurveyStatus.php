<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipSurveyStatus extends Model {
    
    protected $table = "tip_survey_status";
    
    const TIP_SURVEY_STATUS_REQUESTED = 1;
    const TIP_SURVEY_STATUS_OK    = 2;
    
    //Relazione con la tabella repeats
    public function repeats() {
        return $this->hasMany('App\Repeat');
    }
    
}
