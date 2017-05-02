<?php

use Illuminate\Database\Seeder;

//TipUser Table Seed
class TipUserTableSeed extends Seeder {
    
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('tip_user')->get()->count() == 0){
            
            DB::table('tip_user')->insert([
                [
                    'id'          => 1,
                    'name'        => 'admin dipartimento',
                    'description' => 'utente admin per la gestione delle risorse del dipartimento',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 2,
                    'name'        => 'admin ateneo',
                    'description' => 'utente admin per la gestione delle risorse dell\'ateneo',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 3,
                    'name'        => 'professore',
                    'description' => 'utente che effettua la richiesta di prenotazione della risorsa',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
