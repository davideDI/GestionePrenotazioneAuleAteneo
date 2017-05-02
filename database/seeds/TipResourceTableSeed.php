<?php

use Illuminate\Database\Seeder;

//TipResource Table Seed
class TipResourceTableSeed extends Seeder {
    
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('tip_resource')->get()->count() == 0){
            
            DB::table('tip_resource')->insert([
                [
                    'id'              => 1,
                    'name'            => 'aula',
                    'description'     => '',
                    'created_at'      => date("Y-m-d G:i:s"),
                    'updated_at'      => date("Y-m-d G:i:s")
                ],
                [
                    'id'              => 2,
                    'name'            => 'palestra',
                    'description'     => '',
                    'created_at'      => date("Y-m-d G:i:s"),
                    'updated_at'      => date("Y-m-d G:i:s")
                ],
                [
                    'id'              => 3,
                    'name'            => 'laboratorio',
                    'description'     => '',
                    'created_at'      => date("Y-m-d G:i:s"),
                    'updated_at'      => date("Y-m-d G:i:s")
                ],
                [
                    'id'              => 4,
                    'name'            => 'aula magna',
                    'description'     => '',
                    'created_at'      => date("Y-m-d G:i:s"),
                    'updated_at'      => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
