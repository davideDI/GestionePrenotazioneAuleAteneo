<?php

use Illuminate\Database\Seeder;

//Groups Table Seed
class GroupTableSeed extends Seeder {
    
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('groups')->get()->count() == 0){
            
            DB::table('groups')->insert([
                [
                    'id'            => 1,
                    'name'          => 'DISIM Aule',
                    'description'   => 'Ingegneria e scienze dell\'informazione e matematica',
                    'tip_group_id'  => 1,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ],
                [
                    'id'            => 2,
                    'name'          => 'ATENEO Aule',
                    'description'   => 'Aule di Ateneo',
                    'tip_group_id'  => 1,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ],
                [
                    'id'            => 3,
                    'name'          => 'CLA Aule',
                    'description'   => 'Centro Linguistico di Ateneo',
                    'tip_group_id'  => 1,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
