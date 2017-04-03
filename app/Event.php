<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    
    //Relazione con la tabella tip_event
    public function tipEvent() {
        return $this->belongsTo('App\TipEvent');
    }
    
}
