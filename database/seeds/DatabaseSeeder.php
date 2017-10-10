<?php

use Illuminate\Database\Seeder;

//Order of Seeds to call
class DatabaseSeeder extends Seeder {
    
    public function run() {
        
        //Table TipEvents
        $this->call(TipEventTableSeed::class);
        
        //Table TipBookingStatus
        $this->call(TipBookingStatusTableSeed::class);
        
        //Table TipSurveyStatus
        $this->call(TipSurveyStatusTableSeed::class);
        
        //Table TipGroups
        $this->call(TipGroupTableSeed::class);
        
        //Table TipResources
        $this->call(TipResourceTableSeed::class);
        
        //Table TipUsers
        $this->call(TipUserTableSeed::class);
        
        //Table Users
        $this->call(UserTableSeed::class);
        
        //Table Groups
        $this->call(GroupTableSeed::class);
        
        //Table Resources
        $this->call(ResourceTableSeed::class);
        
        //Table Bookings
        $this->call(BookingTableSeed::class);
        
        //Table Repeats
        $this->call(RepeatsTableSeeder::class);
        
        //Table Acl
        $this->call(AclDefaultSeeder::class);
        
    }
}
