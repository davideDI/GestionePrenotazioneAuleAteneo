<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    
    protected $fillable = ['name', 'description', 'num_students', 'booking_date', 'event_date_start', 'event_date_end', 'resource_id', 'tip_event_id'];
    protected $table = 'bookings';

    //Relazione con la tabella tip_booking_status
    public function tipBookingStatus() {
        return $this->belongsTo('App\TipBookingStatus');
    }
    
    //Relazione con la tabella users
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    //Relazione con la tabella resources
    public function resource() {
        return $this->belongsTo('App\Resource');
    }
    
    //Relazione con la tabella tip_event
    public function tipEvent() {
        return $this->belongsTo('App\TipEvent');
    }
    
    /*public static function store(Booking $booking) {
        $booking -> create();
    }*/
    
}
