<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model {
    
    protected $table = 'surveys';
    
    //Relazione con la tabella repeat
    public function repeat() {
        return $this->belongsTo('App\Repeat');
    }
    
    //Relazione con la tabella tip_survey_status
    public function tipSurveyStatus() {
        return $this->belongsTo('App\TipSurveyStatus');
    }
    
}
