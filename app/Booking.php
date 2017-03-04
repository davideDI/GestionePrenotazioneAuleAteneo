<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    
    public static function store(Booking $booking) {

        $booking -> create();
        
    }
    
}
