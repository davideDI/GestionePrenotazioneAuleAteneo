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
                    'name'        => 'admin ateneo',
                    'description' => 'utente admin per la gestione delle risorse dell\'ateneo',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 2,
                    'name'        => 'admin dipartimento',
                    'description' => 'utente admin per la gestione delle risorse del dipartimento',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 3,
                    'name'        => 'professore',
                    'description' => 'utente che effettua la richiesta di prenotazione della risorsa',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 4,
                    'name'        => 'inquirer',
                    'description' => 'uscieri che verificano a campione l\'effettiva occupazione, e in che proporzione, delle risorse prenotate',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 5,
                    'name'        => 'secretary',
                    'description' => 'segreteria dipartimento',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 6,
                    'name'        => 'student',
                    'description' => 'utente studente',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 7,
                    'name'        => 'member',
                    'description' => 'utente membre che non ha ruoli specifici',
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
