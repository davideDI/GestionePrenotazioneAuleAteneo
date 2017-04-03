<?php

use Illuminate\Database\Seeder;

class BookingTableSeed extends Seeder {
    
    //Caricamento dati iniziali tabella Bookings
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        //Si verifica la presenza di dati
        if(DB::table('bookings')->get()->count() == 0){
            
            DB::table('bookings')->insert([
                [
                    'id'                    => 1,
                    'name'                  => 'book',
                    'description'           => 'book desc',
                    'event_date_start'      => date("Y-m-d G:i:s"),
                    'event_date_end'        => date("Y-m-d G:i:s"),
                    'tip_event_id'          => 1,
                    'user_id'               => 1,
                    'resource_id'           => 1,
                    'tip_booking_status_id' => 1,
                    'booking_date'          => date("Y-m-d G:i:s"),
                ]
            ]);
            
        }
        
    }
}
