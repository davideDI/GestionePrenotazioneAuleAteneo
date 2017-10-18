<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipBookingStatus extends Model {
    
    protected $table = "tip_booking_status";
    
    const TIP_BOOKING_STATUS_REQUESTED = 1;
    const TIP_BOOKING_STATUS_WORKING = 2;
    const TIP_BOOKING_STATUS_OK = 3;
    const TIP_BOOKING_STATUS_KO = 4;

    //Relazione con la tabella repeats
    public function repeats() {
        return $this->hasMany('App\Repeat');
    }
    
}
