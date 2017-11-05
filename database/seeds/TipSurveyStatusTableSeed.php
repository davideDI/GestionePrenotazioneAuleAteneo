<?php

use Illuminate\Database\Seeder;

//TipSurveyStatus Table Seed
class TipSurveyStatusTableSeed extends Seeder {
    
    public function run() {
        
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('tip_survey_status')->get()->count() == 0){
            
            DB::table('tip_survey_status')->insert([
                [
                    'id'           => 1,
                    'description'  => 'richiesta',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id'           => 2,
                    'description'  => 'gestita',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ],
                [
                    'id'           => 3,
                    'description'  => 'scartata',
                    'created_at'   => date("Y-m-d G:i:s"),
                    'updated_at'   => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
