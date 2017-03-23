<?php

use Illuminate\Database\Seeder;

class TipBookingStatusTableSeeder extends Seeder {
    
    //Caricamento dati iniziali tabella Tip_booking_status
    public function run() {
        
        //Si verifica la presenza di dati
        // check if table users is empty
        if(DB::table('tip_booking_status')->get()->count() == 0){
            
            DB::table('tip_booking_status')->insert(
                [
                    'id' => 1,
                    'description'  => 'richiesta',
                ],
                [
                    'id' => 2,
                    'description'  => 'in lavorazione',
                ],
                [
                    'id' => 3,
                    'description'  => 'gestita',
                ],
                [
                    'id' => 4,
                    'description'  => 'scartata',
                ]
            );
            
        }
        
    }
    
}
