<?php

use Illuminate\Database\Seeder;

class TipResourcesTableSeeder extends Seeder {
    
    //Caricamento dati iniziali tabella Tip_resources
    public function run() {
        
        //Si verifica la presenza di dati
        // check if table users is empty
        if(DB::table('tip_resources')->get()->count() == 0){
            
            DB::table('tip_resources')->insert(
                [
                    'id_tip_resource' => 1,
                    'name'            => 'aula',
                    'description'     => 'palazzina generica',
                    'created_at'  => timestamp(),
                    'updated_at'  => timestamp()
                ],
                [
                    'id_tip_resource' => 2,
                    'name'            => 'palestra',
                    'description'     => '',
                    'created_at'  => timestamp(),
                    'updated_at'  => timestamp()
                ],
                [
                    'id_tip_resource' => 3,
                    'name'            => 'laboratorio',
                    'description'     => '',
                    'created_at'  => timestamp(),
                    'updated_at'  => timestamp()
                ],
                [
                    'id_tip_resource' => 4,
                    'name'            => 'aula magna',
                    'description'     => '',
                    'created_at'  => timestamp(),
                    'updated_at'  => timestamp()
                ]
            );
            
        }
        
    }
    
}
