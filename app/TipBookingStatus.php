<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipBookingStatus extends Model {
    
    protected $table = "tip_booking_status";
    
    //Relazione con la tabella bookings
    public function bookings() {
        return $this->hasMany('App\Booking');
    }
    
}
