<?php

use Illuminate\Database\Seeder;

//TipUser Table Seed
class UserTableSeed extends Seeder {
    
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('users')->get()->count() == 0){
            
            DB::table('users')->insert([
                [
                    'id'          => 1,
                    'name'        => 'davide',
                    'surname'     => 'ddi',
                    'email'       => 'davide@davide.it',
                    'password'    => bcrypt('davide@davide.it'),
                    'tip_user_id' => 1, //Admin di dipartimento
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 2,
                    'name'        => 'luigi',
                    'surname'     => 'marrone',
                    'email'       => 'luigi@marrone.it',
                    'password'    => bcrypt('luigi@marrone.it'),
                    'tip_user_id' => 2, //Admin di ateneo
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 3,
                    'name'        => 'ateneo',
                    'surname'     => 'ateneo',
                    'email'       => 'ateneo@ateneo.it',
                    'password'    => bcrypt('ateneo@ateneo.it'),
                    'tip_user_id' => 3, //Docente
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                [
                    'id'          => 4,
                    'name'        => 'mario',
                    'surname'     => 'bianchi',
                    'email'       => 'mario@bianchi.it',
                    'password'    => bcrypt('mario@bianchi.it'),
                    'tip_user_id' => 4, //Inquirer
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
