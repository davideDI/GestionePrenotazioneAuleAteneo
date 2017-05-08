<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repeat extends Model {
    
    protected $table = 'repeats';
    
    //Relazione con la tabella users
    public function booking() {
        return $this->belongsTo('App\Booking');
    }
    
    //Relazione con la tabella tip_booking_status
    public function tipBookingStatus() {
        return $this->belongsTo('App\TipBookingStatus');
    }
    
}
