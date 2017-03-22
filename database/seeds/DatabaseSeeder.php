<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    
    public function run() {
        
        //tabella TipEvents
        $this->call(TipEventoTableSeeder::class);
        
    }
    
}
