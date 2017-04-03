<?php

use Illuminate\Database\Seeder;

class TipGroupTableSeed extends Seeder {
    
    //Caricamento dati iniziali tabella Tip_group
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        //Si verifica la presenza di dati
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
