<?php

use Illuminate\Database\Seeder;

class ResourcesTableSeeder extends Seeder {
   
    //Caricamento dati iniziali tabella Resources
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        //Si verifica la presenza di dati
        // check if table users is empty
        if(DB::table('resources')->get()->count() == 0){
            
            DB::table('resources')->insert([
                [
                    'id'                => 1,
                    'name'              => 'A1.1',
                    'description'       => 'primo piano',
                    'id_tip_resource'   => 1,
                    'id_group'          => 1,
                    'created_at'        => date("Y-m-d G:i:s"),
                    'updated_at'        => date("Y-m-d G:i:s")
                ],
                [
                    'id'                => 2,
                    'name'              => 'A1.2',
                    'description'       => 'primo piano',
                    'id_tip_resource'   => 1,
                    'id_group'          => 1,
                    'created_at'        => date("Y-m-d G:i:s"),
                    'updated_at'        => date("Y-m-d G:i:s")
                ],
                [
                    'id'                => 3,
                    'name'              => '101',
                    'description'       => 'piano terra',
                    'id_tip_resource'   => 1,
                    'id_group'          => 2,
                    'created_at'        => date("Y-m-d G:i:s"),
                    'updated_at'        => date("Y-m-d G:i:s")
                ],
                [
                    'id'                => 4,
                    'name'              => '101',
                    'description'       => 'piano terra',
                    'id_tip_resource'   => 1,
                    'id_group'          => 2,
                    'created_at'        => date("Y-m-d G:i:s"),
                    'updated_at'        => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
    
}
