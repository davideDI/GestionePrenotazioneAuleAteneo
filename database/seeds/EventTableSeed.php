<?php

use Illuminate\Database\Seeder;

class EventTableSeed extends Seeder {
    
    //Caricamento dati iniziali tabella events
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        //Si verifica la presenza di dati
        if(DB::table('events')->get()->count() == 0){
            
            DB::table('events')->insert([
                [
                    'id'               => 1,
                    'name'             => 'event',
                    'description'      => 'event desc',
                    'booking_id'       => 1,
                    'tip_event_id'     => 1,
                    'event_date_start' => date("Y-m-d G:i:s"),
                    'event_date_end'   => date("Y-m-d G:i:s"),
                ]
            ]);
            
        }
        
    }
}
