<?php

use Illuminate\Database\Seeder;

class TipEventsTableSeeder extends Seeder {
    
    //Caricamento dati iniziali tabella Tip_events
    public function run() {
        
        //Si verifica la presenza di dati
        // check if table users is empty
        if(DB::table('tip_events')->get()->count() == 0){
            
            DB::table('tip_events')->insert([
                [
                    'id_tip_event' => 1,
                    'name'         => 'esame',
                    'description'  => 'evento di tipo esame',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id_tip_event' => 2,
                    'name'         => 'lezione',
                    'description'  => 'evento di tipo lezione',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id_tip_event' => 3,
                    'name'         => 'seminario',
                    'description'  => 'evento di tipo seminario',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id_tip_event' => 4,
                    'name'         => 'generico',
                    'description'  => 'evento di tipo generico',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
    
}
