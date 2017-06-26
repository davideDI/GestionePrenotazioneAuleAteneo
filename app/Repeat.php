<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repeat extends Model {
    
    protected $fillable = ['event_date_start', 'event_date_end'];
    protected $table = 'repeats';
    
    //Relazione con la tabella users
    public function booking() {
        return $this->belongsTo('App\Booking');
    }
    
    //Relazione con la tabella tip_booking_status
    public function tipBookingStatus() {
        return $this->belongsTo('App\TipBookingStatus');
    }
    
    //Relazione con la tabella surveys
    public function surveys() {
        return $this->hasMany('App\Survey');
    }
    
}
