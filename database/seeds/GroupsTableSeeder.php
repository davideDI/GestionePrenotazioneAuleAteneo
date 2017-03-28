<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder {
    
    //Caricamento dati iniziali tabella Groups
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        //Si verifica la presenza di dati
        // check if table users is empty
        if(DB::table('groups')->get()->count() == 0){
            
            DB::table('groups')->insert([
                [
                    'id'            => 1,
                    'name'          => 'DISIM Aule',
                    'description'   => 'Ingegneria e scienze dell\'informazione e matematica',
                    'id_tip_group'  => 1,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ],
                [
                    'id'            => 2,
                    'name'          => 'ATENEO Aule',
                    'description'   => 'Aule di Ateneo',
                    'id_tip_group'  => 1,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ],
                [
                    'id'            => 3,
                    'name'          => 'CLA Aule',
                    'description'   => 'Centro Linguistico di Ateneo',
                    'id_tip_group'  => 1,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
    
}
