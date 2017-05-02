<?php

use Illuminate\Database\Seeder;

//TipEvent Table Seed
class TipEventTableSeed extends Seeder {
    
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('tip_event')->get()->count() == 0){
            
            DB::table('tip_event')->insert([
                [
                    'id'           => 1,
                    'name'         => 'esame',
                    'description'  => 'evento di tipo esame',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id'           => 2,
                    'name'         => 'lezione',
                    'description'  => 'evento di tipo lezione',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id'           => 3,
                    'name'         => 'seminario',
                    'description'  => 'evento di tipo seminario',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id'           => 4,
                    'name'         => 'generico',
                    'description'  => 'evento di tipo generico',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
