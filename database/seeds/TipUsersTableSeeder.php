<?php

use Illuminate\Database\Seeder;

class TipUsersTableSeeder extends Seeder {
    
    //Caricamento dati iniziali tabella Tip_users
    public function run() {
        
        //Si verifica la presenza di dati
        // check if table users is empty
        if(DB::table('tip_users')->get()->count() == 0){
            
            DB::table('tip_users')->insert([
                [
                    'id_tip_user' => 1,
                    'name'        => 'admin dipartimento',
                    'description' => 'utente admin per la gestione delle risorse del dipartimento',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id_tip_user' => 2,
                    'name'        => 'admin ateneo',
                    'description' => 'utente admin per la gestione delle risorse dell\'ateneo',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id_tip_user' => 3,
                    'name'        => 'professore',
                    'description' => 'utente che effettua la richiesta di prenotazione della risorsa',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
    
}
