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
                    'cn'          => 'admin',
                    'registration_number' => '999999',
                    'tip_user_id' => 1, //Admin di ateneo
                    'created_at'  => date("Y-m-d G:i:s"),
                    'updated_at'  => date("Y-m-d G:i:s")
                ],
                
            ]);
            
        }
        
    }
}
