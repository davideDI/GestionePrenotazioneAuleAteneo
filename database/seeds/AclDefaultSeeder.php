<?php

use Illuminate\Database\Seeder;

class AclDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        date_default_timezone_set('Europe/Rome');
        
        if(DB::table('acl')->get()->count() == 0){
            
            DB::table('acl')->insert([
                [
                    'id'            => 1,
                    'group_id'      => 1,
                    'user_id'       => 1,
                    'enable_access' => 1,        
                    'enable_crud'   => 1,
                    'created_at'    => date("Y-m-d G:i:s"),
                    'updated_at'    => date("Y-m-d G:i:s")
                ]
            ]);
            
        }
        
    }
}
