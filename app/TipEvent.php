<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipEvent extends Model {
    
    protected $table = "tip_event";
    
    const TIP_EVENT_EXAM = 1;
    const TIP_EVENT_LESSON = 2;
    const TIP_EVENT_SEMINARY = 3;
    const TIP_EVENT_GENERIC = 4;

    //Relazione con la tabella bookings
    public function bookings() {
        return $this->hasMany('App\Booking');
    }
    
}
