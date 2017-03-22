<?php

use Illuminate\Database\Seeder;

class TipEventoTableSeeder extends Seeder {
    
    //Caricamento dati iniziali tabella Tip_events
    public function run() {
        
        //Si verifica la presenza di dati
        // check if table users is empty
        if(DB::table('tip_users')->get()->count() == 0){
            
            DB::table('tip_users')->insert(
                [
                    'id_tip_event' => 1,
                    'name'         => 'esame',
                    'description'  => 'evento di tipo esame',
                ],
                [
                    'id_tip_event' => 2,
                    'name'         => 'lezione',
                    'description'  => 'evento di tipo lezione',
                ],
                [
                    'id_tip_event' => 3,
                    'name'         => 'seminario',
                    'description'  => 'evento di tipo seminario',
                ],
                [
                    'id_tip_event' => 4,
                    'name'         => 'generico',
                    'description'  => 'evento di tipo generico',
                ]
            );
            
        }
        
    }
    
}
