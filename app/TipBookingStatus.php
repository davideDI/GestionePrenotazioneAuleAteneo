<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipBookingStatus extends Model {
    
    protected $table = "tip_booking_status";
    
    //Relazione con la tabella repeats
    public function repeats() {
        return $this->hasMany('App\Repeat');
    }
    
}
