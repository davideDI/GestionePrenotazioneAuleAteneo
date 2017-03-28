<?php

use Illuminate\Database\Seeder;

class TipGroupsTableSeeder extends Seeder {
    
    //Caricamento dati iniziali tabella Tip_groups
    public function run() {
        
        //Si verifica la presenza di dati
        // check if table users is empty
        if(DB::table('tip_groups')->get()->count() == 0){
            
            DB::table('tip_groups')->insert([
                [
                    'id_tip_group' => 1,
                    'name'         => 'generico',
                    'description'  => 'palazzina generica',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
    
}
