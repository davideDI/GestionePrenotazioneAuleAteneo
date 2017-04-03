<?php

use Illuminate\Database\Seeder;

class TipResourceTableSeed extends Seeder {
    
    //Caricamento dati iniziali tabella Tip_resource
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        //Si verifica la presenza di dati
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
