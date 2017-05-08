<?php

use Illuminate\Database\Seeder;

//Repeats Table Seed
class RepeatsTableSeeder extends Seeder {
    
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('repeats')->get()->count() == 0){
            
            DB::table('repeats')->insert([
                [
                    'id'                    => 1,
                    'event_date_start'      => date("Y-m-d G:i:s"),
                    'event_date_end'        => date("Y-m-d G:i:s"),
                    'booking_id'            => 1,
                    'tip_booking_status_id' => 1,
                    'created_at'            => date("Y-m-d G:i:s"),
                    'updated_at'            => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
    
}
