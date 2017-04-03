<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipEvent extends Model {
    
    protected $table = "tip_event";
    
    //Relazione con la tabella bookings
    public function bookings() {
        return $this->hasMany('App\Booking');
    }
    
}
