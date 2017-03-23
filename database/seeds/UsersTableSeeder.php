<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
    
    //Caricamento dati iniziali tabella Users
    public function run() {
        
        //Si verifica la presenza di dati
        // check if table users is empty
        if(DB::table('users')->get()->count() == 0){
            
            DB::table('users')->insert(
                [
                    'id'          => 1,
                    'name'        => 'davide',
                    'surname'     => 'ddi',
                    'email'       => 'davide@davide.it',
                    'password'    => 'davide@davide.it',
                    'id_tip_user' => 1,
                    'created_at'  => timestamp(),
                    'updated_at'  => timestamp()
                ],
                [
                    'id'          => 2,
                    'name'        => 'luigi',
                    'surname'     => 'marrone',
                    'email'       => 'luigi@marrone.it',
                    'password'    => 'luigi@marrone.it',
                    'id_tip_user' => 2,
                    'created_at'  => timestamp(),
                    'updated_at'  => timestamp()
                ],
                [
                    'id'          => 3,
                    'name'        => 'ateneo',
                    'surname'     => 'ateneo',
                    'email'       => 'ateneo@ateneo.it',
                    'password'    => 'ateneo@ateneo.it',
                    'id_tip_user' => 3,
                    'created_at'  => timestamp(),
                    'updated_at'  => timestamp()
                ],
                [
                    'id'          => 4,
                    'name'        => 'mario',
                    'surname'     => 'bianchi',
                    'email'       => 'mario@bianchi.it',
                    'password'    => 'mario@bianchi.it',
                    'id_tip_user' => 1,
                    'created_at'  => timestamp(),
                    'updated_at'  => timestamp()
                ]
            );
            
        }
        
    }
    
}
