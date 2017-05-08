<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model {
    
    protected $table = 'surveys';
    
    //Relazione con la tabella users
    public function booking() {
        return $this->belongsTo('App\Booking');
    }
    
    //Relazione con la tabella users
    public function user() {
        return $this->belongsTo('App\User');
    }
    
}
