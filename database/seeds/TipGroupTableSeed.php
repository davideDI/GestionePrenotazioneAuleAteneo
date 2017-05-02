<?php

use Illuminate\Database\Seeder;

//TipGroup Table Seed
class TipGroupTableSeed extends Seeder {
    
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('tip_group')->get()->count() == 0){
            
            DB::table('tip_group')->insert([
                [
                    'id' => 1,
                    'name'         => 'generico',
                    'description'  => 'palazzina generica',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
