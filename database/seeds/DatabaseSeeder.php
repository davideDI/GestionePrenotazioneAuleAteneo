<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    
    public function run() {
        
        //tabella TipEvents
        $this->call(TipEventTableSeed::class);
        
        //tabella TipBookingStatus
        $this->call(TipBookingStatusTableSeed::class);
        
        //tabella TipGroups
        $this->call(TipGroupTableSeed::class);
        
        //tabella TipResources
        $this->call(TipResourceTableSeed::class);
        
        //tabella TipUsers
        $this->call(TipUserTableSeed::class);
        
        //tabella Users
        $this->call(UserTableSeed::class);
        
        //tabella Groups
        $this->call(GroupTableSeed::class);
        
        //tabella Resources
        $this->call(ResourceTableSeed::class);
        
        //tabella Bookings
        $this->call(BookingTableSeed::class);
        
    }
}
