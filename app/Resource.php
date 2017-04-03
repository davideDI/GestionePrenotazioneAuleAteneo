<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model {
    
    //Relazione con la tabella tip_resource
    public function tipResource() {
        return $this->belongsTo('App\TipResource');
    }
    
    //Relazione con la tabella groups
    public function group() {
        return $this->belongsTo('App\Group');
    }
    
    //Relazione con la tabella bookings
    public function bookings() {
        return $this->hasMany('App\Booking');
    }
    
}
