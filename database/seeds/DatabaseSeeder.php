<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    
    public function run() {
        
        //tabella TipEvents
        $this->call(TipEventsTableSeeder::class);
        
        //tabella TipBookingStatus
        $this->call(TipBookingStatusTableSeeder::class);
        
        //tabella TipGroups
        $this->call(TipGroupsTableSeeder::class);
        
        //tabella TipResources
        $this->call(TipResourcesTableSeeder::class);
        
        //tabella TipUsers
        $this->call(TipUsersTableSeeder::class);
        
        //tabella Groups
        $this->call(GroupsTableSeeder::class);
        
        //tabella Resources
        $this->call(ResourcesTableSeeder::class);
        
        //tabella Users
        $this->call(UsersTableSeeder::class);
        
    }
    
}
