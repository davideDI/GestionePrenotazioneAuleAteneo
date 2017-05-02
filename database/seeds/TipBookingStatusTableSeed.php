<?php

use Illuminate\Database\Seeder;

//TipBookingStatus Table Seed
class TipBookingStatusTableSeed extends Seeder {
    
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('tip_booking_status')->get()->count() == 0){
            
            DB::table('tip_booking_status')->insert([
                [
                    'id'           => 1,
                    'description'  => 'richiesta',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id'           => 2,
                    'description'  => 'in lavorazione',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id'           => 3,
                    'description'  => 'gestita',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id'           => 4,
                    'description'  => 'scartata',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
