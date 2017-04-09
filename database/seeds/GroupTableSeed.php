<?php

use Illuminate\Database\Seeder;

class GroupTableSeed extends Seeder {
    
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
                    'tip_group_id'  => 1,
                    'admin_id'      => 1,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ],
                [
                    'id'            => 2,
                    'name'          => 'ATENEO Aule',
                    'description'   => 'Aule di Ateneo',
                    'tip_group_id'  => 1,
                    'admin_id'      => 2,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ],
                [
                    'id'            => 3,
                    'name'          => 'CLA Aule',
                    'description'   => 'Centro Linguistico di Ateneo',
                    'tip_group_id'  => 1,
                    'admin_id'      => 3,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
