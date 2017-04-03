<?php

use Illuminate\Database\Seeder;

class TipBookingStatusTableSeed extends Seeder {
    
    //Caricamento dati iniziali tabella Tip_booking_status
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        //Si verifica la presenza di dati
        if(DB::table('tip_booking_status')->get()->count() == 0){
            
            DB::table('tip_booking_status')->insert([
                [
                    'id'           => 1,
                    'description'  => 'richiesta',
                ],
                [
                    'id'           => 2,
                    'description'  => 'in lavorazione',
                ],
                [
                    'id'           => 3,
                    'description'  => 'gestita',
                ],
                [
                    'id'           => 4,
                    'description'  => 'scartata',
                ]
            ]);
            
        }
        
    }
}
